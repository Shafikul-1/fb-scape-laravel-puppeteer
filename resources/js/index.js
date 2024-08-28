import puppeteer from 'puppeteer';
import fs from 'fs';

let browser;
let data = [];


const contactPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/'; // next div loop

async function fbDetails(links) {
    try {
        // browser = await puppeteer.launch();
        browser = await puppeteer.launch({
            headless: false,
            args: ['--start-maximized'],
        });

        // check Url String
        function checkProfileId(url) {
            const pattern = /profile\.php\?id=\d+/;
            return pattern.test(url);
        }

        for (const link of links) {
            if (!link.startsWith('https://') && !link.startsWith('http://')) {
                data.push({ 'url': link, 'error': 'Invalid URL' });
                continue;
            }

            let url = link;
            const page = await browser.newPage();
            let profileIdUrl = null;
            const currentPageAllData = {};

            try {
                await page.goto(url, { waitUntil: 'networkidle0' });
                if (checkProfileId(url)) {
                    profileIdUrl = page.url();
                }

                // remove popup
                await page.keyboard.press('Escape');

                // Post Data Collect
                const postDetails = await page.evaluate((url) => {

                    const data = {};
                    function textGet(contentPath) {
                        const elementText = document.evaluate(
                            contentPath,
                            document,
                            null,
                            XPathResult.FIRST_ORDERED_NODE_TYPE,
                            null
                        ).singleNodeValue;
                        return elementText.innerText.trim();
                    }

                    // Post Thake Name collect
                    const namePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[1]';
                    const nameText = textGet(namePath);

                    // Post Thake Time Collect
                    const timePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[2]';
                    const timeText = textGet(timePath).replace(/\s+/g, ' ');

                    // Send Data post array
                    return data['postDetails'] = { name: nameText, timeText: timeText, url: url };
                }, url);
                currentPageAllData['postDetails'] = postDetails;
            } catch (error) {
                // console.error(`An Error Ocurred for ${url} : `, error.message);
                data.push({ url, error: error.message });
            }
            await page.close();



            // New Page Contact Details
            const newPage = await browser.newPage();
            let newUrl = '';
            if (checkProfileId(link)) {
                if (profileIdUrl != null) {
                    newUrl = `${profileIdUrl}?sk=about`;
                } else {
                    await newPage.close();
                }
            } else {
                if (url.endsWith('/')) {
                    newUrl = `${link}about_contact_and_basic_info`;
                } else {
                    newUrl = `${link}/about_contact_and_basic_info`;
                }
            }

            try {
                await newPage.goto(newUrl, { waitUntil: 'networkidle0' });
                const contactDetails = await newPage.evaluate(() => {

                    const data = {};
                    function textGet(contentPath) {
                        const elementText = document.evaluate(
                            contentPath,
                            document,
                            null,
                            XPathResult.FIRST_ORDERED_NODE_TYPE,
                            null
                        ).singleNodeValue;
                        return elementText ? elementText.innerText.trim() : 'notFound';
                        // return elementText ? elementText.innerText.trim() : {'notFound': contentPath};
                    }

                    function divCount(countPath) {
                        const nodesSnapShot = document.evaluate(countPath, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                        return nodesSnapShot.snapshotLength;
                    }

                    function divExists(divPath) {
                        const divExists = document.evaluate(`${divPath}/div`, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
                        return divExists;
                    }
                    let detailsData = {};

                    const contactPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[2]/div';
                    const totalDivs = divCount(`${contactPath}/div`);

                    // Loop through each last div and store the path
                    for (let a = 1; a <= totalDivs; a++) {

                        // search Contactinfo
                        const contactDetails = divCount(`${contactPath}/div[${a}]/div/div/div[2]/div`);
                        if (2 <= contactDetails) {
                            for (let c = 2; c <= contactDetails; c++) {
                                let contactInfoLoop = `${contactPath}/div[${a}]/div/div/div[2]/div[${c}]`;
                                const contactInfoKey = textGet(`${contactInfoLoop}/div[2]`);
                                const contactInfoValue = textGet(`${contactInfoLoop}/div[1]`);
                                detailsData[contactInfoKey] = contactInfoValue
                                // detailsData['contactInfoKeyPath'] = `${contactPath}/div[${a}]/div/div/div[2]/div[${c}]/div[1]`;
                            }
                        }

                        // Search Contact next info
                        let loopPath = `${contactPath}/div[${a}]/div/div/div[2]/ul/li/div/div`;
                        const contentLoopPath = divCount(`${loopPath}/div`);
                        if (1 <= contentLoopPath) {
                            for (let b = 1; b <= contentLoopPath; b++) {
                                const contactKey = textGet(`${loopPath}/div[2]`);
                                const contactValue = textGet(`${loopPath}/div[1]`);
                                detailsData[contactKey] = contactValue;
                                // detailsData['keyPath'] = `${loopPath}/div[2]`;
                            }
                        }

                        // Search Social
                        const socialPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[3]/div';
                        const countSocialPath = divCount(`${socialPath}/div`);
                        if (1 <= countSocialPath) {

                            for (let d = 1; d <= countSocialPath; d++) {
                                if (d == 1) {
                                    continue;
                                }
                                const divPath = `${socialPath}/div[${d}]/div/div/div`;


                                let socialtKey = '';
                                let socialtValue = '';
                                if (divExists(divPath)) {
                                    // detailsData['fst'] = `${divPath}/div[2]/ul/li/div/div/div[2]`;
                                    socialtKey = textGet(`${divPath}/div[2]/ul/li/div/div/div[2]`);
                                    socialtValue = textGet(`${divPath}/div[2]/ul/li/div/div/div[1]`);
                                } else {
                                    // detailsData['second'] = `${divPath}/ul/li/div/div/div[2]`;
                                    socialtKey = textGet(`${divPath}/ul/li/div/div/div[2]`);
                                    socialtValue = textGet(`${divPath}/ul/li/div/div/div[1]`);
                                }
                                detailsData[socialtKey] = socialtValue;
                            }

                        }

                    }


                    return data['contactDetails'] = detailsData;
                });


                currentPageAllData['contactDetails'] = contactDetails;
            } catch (error) {
                // console.error(`An Error Ocurred for Contact Details ${newUrl} : `, error.message);
                data.push({ newUrl, error: error.message });
            }
            await newPage.close();


            data.push(currentPageAllData);

        }
    } catch (error) {
        // console.error('Error occurred:', error);
        console.log(JSON.stringify(error));
    } finally {
        if (browser) {
            await browser.close();
        }

        fs.writeFile('output.json', JSON.stringify(data, null, 2), (err) => {
            if (err) {
                console.error('Error writing file:', err);
            } else {
                console.log(`File output.json has been saved.`);
            }
        });
        // console.log(JSON.stringify(data));
    }
}

fbDetails([
    'https://www.facebook.com/ChrisEpworthPhotos',
    'https://www.facebook.com/claireeastmanphotography',
    'https://www.facebook.com/hawkandhoney',
    'https://www.facebook.com/juliacalverphotography'
]);
// const encodedUsernames = process.argv[2];
// let urlArray = JSON.parse(encodedUsernames);
// fbDetails(urlArray);
