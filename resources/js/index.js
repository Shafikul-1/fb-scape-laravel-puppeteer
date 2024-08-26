import puppeteer from 'puppeteer';
import fs from 'fs';

let browser;
let data = [];

async function fbDetails(links) {
    try {
        // browser = await puppeteer.launch();
        browser = await puppeteer.launch({
            headless: false,
            args: ['--start-maximized'],
        });


        for (const link of links) {
            const page = await browser.newPage();
            let url = '';
            const errors = [];

            // Check Valied Link
            if (!url.includes('https://') && !url.includes('http://')) {
                url = link;
            } else {
                console.error('Invalid username type.');
                await page.close();
                continue;
            }

            try {
                await page.goto(url, { waitUntil: 'networkidle0', timeout: 40000 });

                // if scroll page then use
                // await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));

                // remove popup
                await page.keyboard.press('Escape');




                const result = await page.evaluate(() => {
                    const mainPath =
                        '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[1]/div[2]/div/div[1]/div/div/div/div/div[2]/div[2]/div/ul/';
                    const elements = document.evaluate(
                        `${mainPath}div`,
                        document,
                        null,
                        XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,
                        null
                    );
                    const data = {};

                    for (let i = 0; i < elements.snapshotLength; i++) {
                        const element = elements.snapshotItem(i);
                        const iconElement = element.querySelector('img');
                        data[`element_${i}`] = {
                            textContent: element ? element.textContent.trim() : 'Element not found',
                            iconSrc: iconElement ? iconElement.src : ''
                        };
                    }

                    data['element_100'] = { url: window.location.href };
                    return data;
                });

                data.push(result);

            } catch (error) {
                console.error(`An Error Ocurred for ${url} : `, error.message);
                data.push({ url, error: error.message });
            }

            await page.close();
        }
    } catch (error) {
        console.error('Error occurred:', error);
    } finally {
        if (browser) {
            await browser.close();
        }

        // console.log(JSON.stringify(data));
        fs.writeFile('output.json', JSON.stringify(data, null, 2), (err) => {
            if (err) {
                console.error('Error writing file:', err);
            } else {
                console.log(`File output.json has been saved.`);
            }
        });
    }
}

fbDetails([
    'https://www.facebook.com/TroyMichaelPhotgraphy',
    'https://www.facebook.com/profile.php?id=61552158826567'
]);


