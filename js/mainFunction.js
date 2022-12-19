// ✅ Or create a reusable function
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
}

function formatDate(date = new Date()) {
    return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
    ].join('-');
}

// 👇️ 20220119 (get today's date) (yyyymmdd)
// console.log(formatDate());

// //  👇️️ 20250509 (yyyymmdd)
// console.log(formatDate(new Date("2025.05.09")));