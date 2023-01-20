<?php
header('Access-Control-Allow-Origin: *');
?>
<script>
    let cache = {};
    async function getData(url) {
        let result = "";
        if (cache[url] !== undefined) return cache[url].value;

        await fetch(url)
            .then(response => response.json())
            .then(json => cache[url] = {
                time: new Date(),
                value: json
            });

        return cache[url].value;
    }

    // Interval to clear cache;
    setInterval(function() {
        if (Object.keys(cache).length > 0) {
            let currentTime = new Date();
            Object.keys(cache).forEach(key => {
                let seconds = currentTime - cache[key].time;

                if (seconds > 10000) {
                    delete cache[key];
                    console.log(`${key}'s cache deleted`)
                }
            })
        }
    }, 3000);

    getData("http://43.72.52.179/VLOGapp/cam.php?Page=CCTV")
        .then(data => console.log(data));
</script>