const { Builder, By, Capabilities } = require('selenium-webdriver');

const capabilities = Capabilities.chrome();
capabilities.set('chromeOptions', {
  args: [
    '--headless',
    '--no-sandbox',
    '--disable-gpu',
    '--window-size=1980,1200',
    '--user-data-dir=test',
    '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
    '--lang=ja-JP',
    // other chrome options
  ],
});

(async function example() {
  const driver = await new Builder().forBrowser('chrome').withCapabilities(capabilities).build();
  try {
//    await driver.execute_script('const newProto = navigator.__proto__;delete newProto.webdriver;navigator.__proto__ = newProto;')
    console.log('start');
    await driver.get("https://suzuri.jp/login?next=%2F")
    await driver.sleep(1000)
    await driver.findElement(By.id("session_name")).sendKeys("frank.frazetta@gmail.com")
    await driver.findElement(By.id("session_password")).sendKeys("into08452")
    await driver.findElement(By.css(".login-submit")).click()

    await driver.sleep(4000)
    await driver.findElement(By.css(".ncgr-avatar__name")).click()
    await driver.findElement(By.css(".account-navigation__item:nth-child(2) .account-navigation__label")).click()
    console.log('next');
    await driver.sleep(8000)
    await driver.executeScript("window.scrollTo(0,523)")
    await driver.executeScript("window.scrollTo(0,2771)")
    await driver.findElement(By.xpath("//input[@type=\'file\']")).sendKeys("export.png")
    console.log('upload');
    await driver.sleep(10000)
    await driver.findElement(By.id("material-title")).click()
    await driver.findElement(By.id("material-title")).sendKeys("NIKKEI225Tシャツ")
    await driver.findElement(By.id("material-description")).click()
    await driver.findElement(By.css(".value-toribun")).click()
    await driver.findElement(By.id("material-description")).click()
    await driver.findElement(By.id("material-description")).sendKeys("NIKKEI225Tシャツ\\nNIKKEI225Tシャツ\\nNIKKEI225Tシャツ\\nNIKKEI225Tシャツ\\nNIKKEI225Tシャツ\\nNIKKEI225Tシャツ")
    await driver.findElement(By.css(".materials__step3-card")).click()
    await driver.findElement(By.id("material-price")).click()
    await driver.findElement(By.id("material-price")).sendKeys("1000")
    await driver.findElement(By.css(".materials__step3-card")).click()
    await driver.findElement(By.css(".ncgr-checkbox__background > .fas")).click()
    await driver.findElement(By.css(".confirm-open")).click()
    await driver.findElement(By.id("publish")).click()
  } catch(e) {
    console.log(e);
    console.log(driver.current_url);


    source = await driver.getPageSource();
//    console.log(source);

    var fs = require("fs");
    fs.writeFileSync("error.html", source);

    const base64 = await driver.takeScreenshot();
    const buffer = Buffer.from(base64, 'base64');
    fs.writeFileSync('screenshot.jpg', buffer);
  } finally {
    await driver.quit();
    console.log('finish');
  }
}());
