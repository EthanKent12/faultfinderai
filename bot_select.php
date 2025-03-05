<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Bot</title>
    <link rel="stylesheet" href="botselect.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchBots();
        });

        function fetchBots() {
            fetch('fetch_bots.php')
                .then(response => response.json())
                .then(data => {
                    let botContainer = document.getElementById("bot-list");
                    botContainer.innerHTML = ""; // Clear any existing content

                    data.forEach(bot => {
                        let botCard = document.createElement("div");
                        botCard.className = "bot-card";
                        botCard.innerHTML = `
                            <h3>${bot.Name}</h3>
                            <button onclick="selectBot(${bot.ProductID})">View Logs</button>
                        `;
                        botContainer.appendChild(botCard);
                    });
                })
                .catch(error => console.error('Error fetching bots:', error));
        }

        function selectBot(botId) {
            window.location.href = `logs.php?bot_id=${botId}`;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Select a Bot</h1>
        <div id="bot-list">
            <p>Loading bots...</p>
        </div>
    </div>
</body>
</html>