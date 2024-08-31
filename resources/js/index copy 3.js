import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

let browser;

async function fbDetails(getInfo) {
    // Create Dir
    const currentPath = path.resolve();

    // // js path
    // const dirName = currentPath + '/fbData';

    // laravel path
    const dirName = currentPath + '/resources/js/fbData';
    if (!fs.existsSync(dirName)) {
        fs.mkdirSync(dirName, { recursive: true });
    }
console.log(getInfo);

    // try {
    //     browser = await puppeteer.launch();
    //     // browser = await puppeteer.launch({
    //     //     headless: false,
    //     //     args: ['--start-maximized'],
    //     // });

    //     // check Url String
    //     function checkProfileId(url) {
    //         const pattern = /profile\.php\?id=\d+/;
    //         return pattern.test(url);
    //     }
    //     let allData = [];

    //     for (const getDatas of getInfo) {
    //         let data = [];
    //         const currentPageAllData = {};
    //         let url = getDatas.link;

    //         // Basic Info
    //         const basicData = {
    //             url: getDatas.link,
    //             user_id: getDatas.user_id
    //         };
    //         currentPageAllData['basicData'] = basicData;

    //         // New Page
    //         const page = await browser.newPage();
    //         let profileIdUrl = null;

    //         try {
    //             await page.goto(url, { waitUntil: 'networkidle0' });
    //             if (checkProfileId(url)) {
    //                 profileIdUrl = page.url();
    //             }

    //             // remove popup
    //             await page.keyboard.press('Escape');

    //             // Post Data Collect
    //             const postDetails = await page.evaluate(() => {
    //                 const namePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[1]';
    //                 const timePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[2]';

    //                 function textGet(contentPath) {
    //                     const elementText = document.evaluate(contentPath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
    //                     return elementText.innerText.trim();
    //                 }

    //                 const nameText = textGet(namePath);
    //                 const timeText = textGet(timePath).replace(/\s+/g, ' ');
    //                 return {
    //                     name: nameText,
    //                     timeText: timeText
    //                 };

    //             });
    //             currentPageAllData['postDetails'] = postDetails;
    //         } catch (error) {
    //             currentPageAllData['First Page Error'] = error.message;
    //         }
    //         await page.close();

    //         // New Page Contact Details
    //         const newPage = await browser.newPage();
    //         let newUrl = '';
    //         if (checkProfileId(url)) {
    //             if (profileIdUrl != null) {
    //                 newUrl = `${profileIdUrl}?sk=about`;
    //             } else {
    //                 await newPage.close();
    //             }
    //         } else {
    //             if (url.endsWith('/')) {
    //                 newUrl = `${url}about_contact_and_basic_info`;
    //             } else {
    //                 newUrl = `${url}/about_contact_and_basic_info`;
    //             }
    //         }


    //         try {
    //             await newPage.goto(newUrl, { waitUntil: 'networkidle0' });
    //             const contactDetails = await newPage.evaluate(() => {

    //                 const data = {};
    //                 function textGet(contentPath) {
    //                     const elementText = document.evaluate(contentPath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
    //                     return elementText ? elementText.innerText.trim() : 'notFound';
    //                 }

    //                 function divCount(countPath) {
    //                     const nodesSnapShot = document.evaluate(countPath, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
    //                     return nodesSnapShot.snapshotLength;
    //                 }

    //                 function divExists(divPath) {
    //                     const divExists = document.evaluate(`${divPath}/div`, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
    //                     return divExists;
    //                 }
    //                 let detailsData = {};

    //                 const contactPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[2]/div';
    //                 const totalDivs = divCount(`${contactPath}/div`);

    //                 // Loop through each last div and store the path
    //                 for (let a = 1; a <= totalDivs; a++) {

    //                     // search Contactinfo
    //                     const contactDetails = divCount(`${contactPath}/div[${a}]/div/div/div[2]/div`);
    //                     if (2 <= contactDetails) {
    //                         for (let c = 2; c <= contactDetails; c++) {
    //                             let contactInfoLoop = `${contactPath}/div[${a}]/div/div/div[2]/div[${c}]`;
    //                             const contactInfoKey = textGet(`${contactInfoLoop}/div[2]`);
    //                             const contactInfoValue = textGet(`${contactInfoLoop}/div[1]`);
    //                             detailsData[contactInfoKey] = contactInfoValue
    //                             // detailsData['contactInfoKeyPath'] = `${contactPath}/div[${a}]/div/div/div[2]/div[${c}]/div[1]`;
    //                         }
    //                     }

    //                     // Search Contact next info
    //                     let loopPath = `${contactPath}/div[${a}]/div/div/div[2]/ul/li/div/div`;
    //                     const contentLoopPath = divCount(`${loopPath}/div`);
    //                     if (1 <= contentLoopPath) {
    //                         for (let b = 1; b <= contentLoopPath; b++) {
    //                             const contactKey = textGet(`${loopPath}/div[2]`);
    //                             const contactValue = textGet(`${loopPath}/div[1]`);
    //                             detailsData[contactKey] = contactValue;
    //                             // detailsData['keyPath'] = `${loopPath}/div[2]`;
    //                         }
    //                     }

    //                     // Search Social
    //                     const socialPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[3]/div';
    //                     const countSocialPath = divCount(`${socialPath}/div`);
    //                     if (1 <= countSocialPath) {

    //                         for (let d = 1; d <= countSocialPath; d++) {
    //                             if (d == 1) {
    //                                 continue;
    //                             }
    //                             const divPath = `${socialPath}/div[${d}]/div/div/div`;

    //                             let socialtKey = '';
    //                             let socialtValue = '';
    //                             if (divExists(divPath)) {
    //                                 // detailsData['fst'] = `${divPath}/div[2]/ul/li/div/div/div[2]`;
    //                                 socialtKey = textGet(`${divPath}/div[2]/ul/li/div/div/div[2]`);
    //                                 socialtValue = textGet(`${divPath}/div[2]/ul/li/div/div/div[1]`);
    //                             } else {
    //                                 // detailsData['second'] = `${divPath}/ul/li/div/div/div[2]`;
    //                                 socialtKey = textGet(`${divPath}/ul/li/div/div/div[2]`);
    //                                 socialtValue = textGet(`${divPath}/ul/li/div/div/div[1]`);
    //                             }
    //                             detailsData[socialtKey] = socialtValue;
    //                         }

    //                     }
    //                 }

    //                 return data['contactDetails'] = detailsData;
    //             });
    //             currentPageAllData['contactDetails'] = contactDetails;
    //         } catch (error) {
    //             currentPageAllData['Second Page Error'] = error.message;
    //         }

    //         await newPage.close();
    //         data.push(currentPageAllData);
    //         allData = allData.concat(data);

    //         fs.writeFile(dirName + '/running.json', JSON.stringify(allData, null, 2), (err) => {
    //             if (err) {
    //                 console.error(JSON.stringify(err));
    //             }
    //         });

    //     }
    // } catch (error) {
    //     // console.error('Error occurred:', error);
    //     console.log(JSON.stringify(error));
    // } finally {
    //     if (browser) {
    //         await browser.close();
    //     }

    //     if (fs.existsSync(dirName + '/running.json')) {
    //         const randomNumber = Math.random();
    //         let newName = dirName + '/data_' + Math.floor(randomNumber * 200) + '_.json';

    //         if (fs.existsSync(newName)) {
    //             newName = dirName + '/data_' + Math.floor(randomNumber * 20000) + '_.json';
    //         }

    //         fs.rename(dirName + '/running.json', newName, (err) => {
    //             if (err) {
    //                 console.log(JSON.stringify(err));
    //             }
    //         })

    //     } else {
    //         console.log('file not exits');
    //         // console.log(JSON.stringify('file not exits'));
    //     }
    //     console.log(JSON.stringify('Work Complete'));
    // }
}

// const getInfo = [
//     {
//         "id": 43,
//         "link": "https:\/\/www.facebook.com\/RichyScottphotography",
//         "status": "noaction",
//         "check": "valid",
//         "user_id": 2,
//         "created_at": "2024-08-31T05:52:47.000000Z",
//         "updated_at": "2024-08-31T05:52:47.000000Z"
//     },
//     {
//         "id": 44,
//         "link": "https:\/\/www.facebook.com\/profile.php?id=100033227535681",
//         "status": "noaction",
//         "check": "valid",
//         "user_id": 2,
//         "created_at": "2024-08-31T05:52:47.000000Z",
//         "updated_at": "2024-08-31T05:52:47.000000Z"
//     }
// ];

const getInfo = process.argv[2];
fbDetails(getInfo);
