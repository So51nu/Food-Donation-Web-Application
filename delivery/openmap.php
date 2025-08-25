<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Tracking System</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #6C63FF;
            --secondary: #FFD700;
            --accent: #8A84FF;
            --dark: #2D3748;
            --light: #ffffff;
            --gray: #F7FAFC;
            --gradient: linear-gradient(135deg, #6C63FF, #8A84FF);
            --card-shadow: 0 4px 20px rgba(108, 99, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--gray);
            min-height: 100vh;
        }

        .header {
            background: var(--gradient);
            color: var(--light);
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: var(--light);
            text-decoration: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--light);
            color: var(--primary);
        }

        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
        }

        .info-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-card {
            background: var(--light);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(108, 99, 255, 0.1);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(108, 99, 255, 0.2);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light);
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
        }

        .card-title {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-content {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .map-container {
            background: var(--light);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(108, 99, 255, 0.1);
        }

        .map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .map-title {
            font-size: 1.5rem;
            color: var(--dark);
            font-weight: 600;
        }

        .control-button {
            background: var(--gradient);
            color: var(--light);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
        }

        .control-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
        }

        #map-container {
            height: 600px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: rgba(108, 99, 255, 0.1);
            border-radius: 25px;
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .pulse {
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(108, 99, 255, 0.7);
            }
            
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(108, 99, 255, 0);
            }
            
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(108, 99, 255, 0);
            }
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .info-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            #map-container {
                height: 400px;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
            }
        }
        .nav-link i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Food<span style="font-weight: 300">Donate</span></h1>
            <nav class="nav-links">
                <a href="delivery.php" class="nav-link">Home</a>
                <a href="#" class="nav-link active">Map</a>
                <a href="deliverymyord.php" class="nav-link">My Orders</a>
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <div class="info-cards">
            <div class="info-card">
                <div class="card-header">
                    <div class="icon-circle">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h2 class="card-title">Current Location</h2>
                </div>
                <div class="card-content" id="city-name">Detecting location...</div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <div class="icon-circle">
                        <i class="fas fa-location-arrow"></i>
                    </div>
                    <h2 class="card-title">Address</h2>
                </div>
                <div class="card-content" id="address">Loading address details...</div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <div class="icon-circle">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h2 class="card-title">Network Details</h2>
                </div>
                <div class="card-content">
                    <p>IP: <span id="ip">Loading...</span></p>
                    <p>Country: <span id="country">Loading...</span></p>
                </div>
            </div>
        </div>

        <div class="map-container">
            <div class="map-header">
                <h2 class="map-title">Live Location Tracking</h2>
                <button onclick="centerMap()" class="control-button">
                    <i class="fas fa-crosshairs"></i>
                    Center Map
                </button>
            </div>
            <div id="map-container"></div>
            <div class="status-indicator">
                <div class="pulse"></div>
                <span>Live tracking active</span>
            </div>
        </div>
    </div>

    <script>
        // Your existing JavaScript code remains the same
        let map;
        let userMarker;

        function initMap() {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map = L.map('map-container').setView(userLocation, 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                userMarker = L.marker(userLocation).addTo(map);
                userMarker.bindPopup("<b>Your Location</b>").openPopup();

                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${userLocation.lat}&lon=${userLocation.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('address').innerHTML = data.display_name;
                        document.getElementById('city-name').innerHTML = data.address.city || data.address.town;
                    });
            });
        }

        function centerMap() {
            if (map && userMarker) {
                map.setView(userMarker.getLatLng(), 15);
            }
        }

        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                document.getElementById('ip').innerHTML = data.ip;
                document.getElementById('country').innerHTML = data.country_name;
            });

        initMap();

        setInterval(() => {
            navigator.geolocation.getCurrentPosition(position => {
                const newLatLng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                if (userMarker) {
                    userMarker.setLatLng(newLatLng);
                }
            });
        }, 10000);
    </script>
</body>
</html>

