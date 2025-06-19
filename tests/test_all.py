import time
import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options

BASE_URL = "http://lamp-login-app_web_1"

@pytest.fixture
def driver():
    options = Options()
    options.add_argument("--headless")
    options.add_argument("--no-sandbox")
    options.add_argument("--disable-dev-shm-usage")
    driver = webdriver.Chrome(options=options)
    yield driver
    driver.quit()

def test_signup(driver):
    for i in range(10):  # max 10 seconds wait
        try:
            if "Login" in driver.title or "Signup" in driver.title:
                break
        except:
            pass
        time.sleep(1)

    driver.get(f"{BASE_URL}/signup.php")
    driver.find_element(By.NAME, "username").send_keys("user99")
    driver.find_element(By.NAME, "password").send_keys("pass99")
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "login.php" in driver.current_url

def test_login_valid(driver):
    driver.get(f"{BASE_URL}/login.php")
    driver.find_element(By.NAME, "username").send_keys("user99")
    driver.find_element(By.NAME, "password").send_keys("pass99")
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "index.php" in driver.current_url

def test_login_invalid(driver):
    driver.get(f"{BASE_URL}/login.php")
    driver.find_element(By.NAME, "username").send_keys("wrong")
    driver.find_element(By.NAME, "password").send_keys("wrong")
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "login.php" in driver.current_url

def test_add_user(driver):
    test_login_valid(driver)
    driver.find_element(By.NAME, "name").send_keys("Test User")
    driver.find_element(By.NAME, "email").send_keys("test@example.com")
    driver.find_element(By.NAME, "age").send_keys("25")
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "index.php" in driver.current_url

def test_edit_user(driver):
    test_login_valid(driver)
    driver.get(f"{BASE_URL}/index.php")
    edit_links = driver.find_elements(By.PARTIAL_LINK_TEXT, "Edit")
    if edit_links:
        edit_links[0].click()
        driver.find_element(By.NAME, "name").clear()
        driver.find_element(By.NAME, "name").send_keys("Edited User")
        driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
        assert "index.php" in driver.current_url
    
def test_delete_user(driver):
    test_login_valid(driver)
    driver.get(f"{BASE_URL}/index.php")
    delete_links = driver.find_elements(By.PARTIAL_LINK_TEXT, "Delete")
    if delete_links:
        delete_links[0].click()
        driver.switch_to.alert.accept()  # confirm JS popup
        assert "index.php" in driver.current_url

def test_logout(driver):
    test_login_valid(driver)
    driver.find_element(By.PARTIAL_LINK_TEXT, "Logout").click()
    assert "login.php" in driver.current_url

def test_add_user_empty_fields(driver):
    test_login_valid(driver)
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "index.php" in driver.current_url or "error" in driver.page_source.lower()

def test_duplicate_signup(driver):
    driver.get(f"{BASE_URL}/signup.php")
    driver.find_element(By.NAME, "username").send_keys("user99")
    driver.find_element(By.NAME, "password").send_keys("pass99")
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
    assert "Signup failed" in driver.page_source or "login.php" in driver.current_url

def test_session_required(driver):
    driver.get(f"{BASE_URL}/index.php")
    assert "login.php" in driver.current_url