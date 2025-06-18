<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Peta Lintas JPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .map-container {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            width: 95%; /* Make it a bit wider */
            max-width: 1400px; /* Max width for larger screens */
            height: 700px; /* Increased height for better viewing */
            margin: 20px auto; /* Center the container and add some margin */
            border: 1px solid #ddd; /* Add a subtle border */
            background-color: #fff; /* White background for the map area */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        #mapSvg {
            transform-origin: center center;
            transition: transform 0.1s ease-out; /* Smoother transition */
            max-width: 100%; /* Ensure SVG scales within its container */
            height: auto; /* Maintain aspect ratio */
            user-select: none; /* Prevent text selection during drag */
            touch-action: none; /* Prevent browser default touch actions */
        }

        .jpl-point {
            cursor: help; /* Indicate it's interactive */
            transition: fill 0.2s ease-in-out; /* Smooth color change */
        }

        .jpl-point:hover {
            opacity: 0.8; /* Slight opacity change on hover */
        }

        .jpl-label {
            font-size: 10px; /* Slightly smaller for compactness */
            text-anchor: middle;
            fill: #333; /* Darker text for readability */
            pointer-events: none; /* Allow clicks to pass through to circle */
        }

        .station-label {
            font-size: 14px; /* Larger for stations */
            font-weight: bold;
            text-anchor: middle;
            fill: #000;
            pointer-events: none;
        }

        .alert-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Space between logos */
            margin-bottom: 15px; /* Space below logos */
        }

        .zoom-controls {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            background-color: #343a40;
            color: #fff;
            font-size: 0.9em;
        }

        /* Style for the railway lines */
        .railway-line {
            stroke-width: 10; /* Thicker lines for visual impact */
            fill: none;
            stroke-linecap: round; /* Round caps for cleaner connections */
        }

        /* CSS for the pulsing effect */
        @keyframes pulse-map {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        .jpl-point.pulse-active {
            animation: pulse-map 2s infinite;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Resort Sintel PD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="interface.php">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            JPL Divre II
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="DaftarJPL/index.php">Daftar JPL</a></li>
                            <li><a class="dropdown-item" href="PetaLintas/index.php">Peta Lintas</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Daftar Kerusakan JPL</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link disabled" href="#">Struktur Organisasi</a></li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center mt-3">
        <div class="alert alert-primary" role="alert">
            <div class="alert-logo-container">
                <img src="/DeteksiPerlintasan/img/bumn.png" alt="BUMN Logo" class="img-fluid" style="width: 120px; height: auto;"/>
                <img src="/DeteksiPerlintasan/img/KAI.png" alt="KAI Logo" class="img-fluid" style="width: 120px; height: auto;"/>
            </div>
            <h1>Halaman Peta Lintas JPL DIVRE II</h1>
            <p>Website created by <i>@Resort Sintel PD</i></p>
        </div>
    </div>

    <div class="zoom-controls">
        <button id="zoomIn" class="btn btn-primary">
            <i class="fas fa-search-plus me-1"></i> Zoom In
        </button>
        <button id="zoomOut" class="btn btn-secondary">
            <i class="fas fa-search-minus me-1"></i> Zoom Out
        </button>
    </div>

    <div class="map-container">
        <svg id="mapSvg" viewBox="0 0 1200 650">
            <line x1="100" y1="150" x2="600" y2="150" stroke="#E30026" class="railway-line" />
            <line x1="600" y1="150" x2="600" y2="350" stroke="#004A7F" class="railway-line" />
            <line x1="600" y1="350" x2="1100" y2="350" stroke="#FFD700" class="railway-line" />
            <line x1="600" y1="350" x2="100" y2="350" stroke="#00A859" class="railway-line" />
            <line x1="100" y1="350" x2="100" y2="550" stroke="#808080" class="railway-line" />
            <line x1="100" y1="350" x2="300" y2="350" stroke="#800080" class="railway-line" />
            <line x1="300" y1="350" x2="300" y2="550" stroke="#A52A2A" class="railway-line" />
            <line x1="300" y1="350" x2="50" y2="350" stroke="#008080" class="railway-line" />

            <circle cx="100" cy="150" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="100" y="130" class="station-label">IDA</text>

            <circle cx="600" cy="150" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="600" y="130" class="station-label">BKP</text>

            <circle cx="600" cy="350" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="600" y="330" class="station-label">PD</text>

            <circle cx="1100" cy="350" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="1100" y="330" class="station-label">PLA</text>

            <circle cx="100" cy="350" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="100" y="330" class="station-label">DUK</text>

            <circle cx="100" cy="550" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="100" y="570" class="station-label">BIM</text>

            <circle cx="300" cy="350" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="300" y="330" class="station-label">LA</text>

            <circle cx="300" cy="550" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="300" y="570" class="station-label">NRS</text>

            <circle cx="50" cy="350" r="10" style="fill: black; stroke: white; stroke-width: 3;" />
            <text x="50" y="330" class="station-label">KTN</text>

            <circle cx="170" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 09 (IDA-BKP): Normal</title> </circle>
            <text x="170" y="140" class="jpl-label">JPL 09</text> <text x="170" y="165" class="jpl-label">IDA-BKP</text>

            <circle cx="240" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 08 (IDA-BKP): Normal</title> </circle>
            <text x="240" y="140" class="jpl-label">JPL 08</text> <text x="240" y="165" class="jpl-label">IDA-BKP</text>

            <circle cx="310" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 07 (IDA-BKP): Normal</title> </circle>
            <text x="310" y="140" class="jpl-label">JPL 07</text> <text x="310" y="165" class="jpl-label">IDA-BKP</text>

            <circle cx="380" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 03 (IDA-BKP): Normal</title> </circle>
            <text x="380" y="140" class="jpl-label">JPL 03</text> <text x="380" y="165" class="jpl-label">IDA-BKP</text>

            <circle cx="450" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 02 (IDA-BKP): Normal</title> </circle>
            <text x="450" y="140" class="jpl-label">JPL 02</text> <text x="450" y="165" class="jpl-label">IDA-BKP</text>

            <circle cx="520" cy="150" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 01 (IDA-BKP): Normal</title> </circle>
            <text x="520" y="140" class="jpl-label">JPL 01</text> <text x="520" y="165" class="jpl-label">IDA-BKP</text>
            
            <circle cx="600" cy="190" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 04 (BKP-PD): Normal</title> </circle>
            <text x="625" y="190" class="jpl-label">JPL 04</text> <text x="625" y="205" class="jpl-label">BKP-PD</text>

            <circle cx="600" cy="230" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 05 (BKP-PD): Normal</title> </circle>
            <text x="625" y="230" class="jpl-label">JPL 05</text> <text x="625" y="245" class="jpl-label">BKP-PD</text>

            <circle cx="600" cy="270" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 06 (BKP-PD): Normal</title> </circle>
            <text x="625" y="270" class="jpl-label">JPL 06</text> <text x="625" y="285" class="jpl-label">BKP-PD</text>

            <circle cx="600" cy="310" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 07 (BKP-PD): Normal</title> </circle>
            <text x="625" y="310" class="jpl-label">JPL 07</text> <text x="625" y="325" class="jpl-label">BKP-PD</text>

            <circle cx="670" cy="350" r="6" class="jpl-point" id="jpl01-pdpla-map-circle" style="fill: #00FF7F; stroke: black; stroke-width: 2;">
                <title>Status JPL 01 PD-PLA</title>
            </circle>
            <text x="670" y="340" class="jpl-label">JPL 01</text> <text x="670" y="365" class="jpl-label">PD-PLA</text>

            <circle cx="740" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 02 (PD-PLA): Normal</title> </circle>
            <text x="740" y="340" class="jpl-label">JPL 02</text> <text x="740" y="365" class="jpl-label">PD-PLA</text>

            <circle cx="810" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 03 (PD-PLA): Normal</title> </circle>
            <text x="810" y="340" class="jpl-label">JPL 03</text> <text x="810" y="365" class="jpl-label">PD-PLA</text>

            <circle cx="880" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 04 (PD-PLA): Normal</title> </circle>
            <text x="880" y="340" class="jpl-label">JPL 04</text> <text x="880" y="365" class="jpl-label">PD-PLA</text>

            <circle cx="950" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 05 (PD-PLA): Normal</title> </circle>
            <text x="950" y="340" class="jpl-label">JPL 05</text> <text x="950" y="365" class="jpl-label">PD-PLA</text>

            <circle cx="1020" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 06 (PD-PLA): Normal</title> </circle>
            <text x="1020" y="340" class="jpl-label">JPL 06</text> <text x="1020" y="365" class="jpl-label">PD-PLA</text>
            
            <circle cx="530" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 08 (PD-TAB): Normal</title> </circle>
            <text x="530" y="340" class="jpl-label">JPL 08</text> <text x="530" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="460" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 09 (PD-TAB): Normal</title> </circle>
            <text x="460" y="340" class="jpl-label">JPL 09</text> <text x="460" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="390" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 10 (PD-TAB): Normal</title> </circle>
            <text x="390" y="340" class="jpl-label">JPL 10</text> <text x="390" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="320" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 14 (PD-TAB): Normal</title> </circle>
            <text x="320" y="340" class="jpl-label">JPL 14</text> <text x="320" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="250" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 15 (PD-TAB): Normal</title> </circle>
            <text x="250" y="340" class="jpl-label">JPL 15</text> <text x="250" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="180" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 17 (PD-TAB): Normal</title> </circle>
            <text x="180" y="340" class="jpl-label">JPL 17</text> <text x="180" y="365" class="jpl-label">PD-TAB</text>

            <circle cx="100" cy="400" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 01 (DUK-BIM): Normal</title> </circle>
            <text x="125" y="400" class="jpl-label">JPL 01</text> <text x="125" y="415" class="jpl-label">DUK-BIM</text>

            <circle cx="100" cy="450" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 02 (DUK-BIM): Normal</title> </circle>
            <text x="125" y="450" class="jpl-label">JPL 02</text> <text x="125" y="465" class="jpl-label">DUK-BIM</text>

            <circle cx="100" cy="500" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 21 (TAB-DUK): Normal</title> </circle>
            <text x="75" y="500" class="jpl-label">JPL 21</text> <text x="75" y="515" class="jpl-label">TAB-DUK</text>

            <circle cx="300" cy="400" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 6 (LA-NRS): Normal</title> </circle>
            <text x="325" y="400" class="jpl-label">JPL 6</text> <text x="325" y="415" class="jpl-label">LA-NRS</text>

            <circle cx="300" cy="450" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 7 (LA-NRS): Normal</title> </circle>
            <text x="325" y="450" class="jpl-label">JPL 7</text> <text x="325" y="465" class="jpl-label">LA-NRS</text>

            <circle cx="300" cy="500" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 20 (LA-NRS): Normal</title> </circle>
            <text x="325" y="500" class="jpl-label">JPL 20</text> <text x="325" y="515" class="jpl-label">LA-NRS</text>

            <circle cx="230" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 30a (DUK-PRU): Normal</title> </circle>
            <text x="230" y="340" class="jpl-label">JPL 30a</text> <text x="230" y="365" class="jpl-label">DUK-PRU</text>

            <circle cx="160" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 33a (PRU-LA): Normal</title> </circle>
            <text x="160" y="340" class="jpl-label">JPL 33a</text> <text x="160" y="365" class="jpl-label">PRU-LA</text>

            <circle cx="225" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 34 (PRU-LA): Normal</title> </circle>
            <text x="225" y="340" class="jpl-label">JPL 34</text> <text x="225" y="365" class="jpl-label">PRU-LA</text>
            
            <circle cx="120" cy="350" r="6" class="jpl-point" style="fill: #00FF7F; stroke: black; stroke-width: 2;"> <title>JPL 42 (LA-KTN): Normal</title> </circle>
            <text x="120" y="340" class="jpl-label">JPL 42</text> <text x="120" y="365" class="jpl-label">LA-KTN</text>
        </svg>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Resort Sintel PD. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const svgElement = document.getElementById("mapSvg");
        let scale = 1;
        let translateX = 0;
        let translateY = 0;
        const zoomStep = 0.2; // Increased zoom step for quicker changes
        const minScale = 0.5; // Minimum zoom out level
        const maxScale = 3;   // Maximum zoom in level

        function updateTransform() {
            svgElement.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
        }

        // Panning functionality
        let isDragging = false;
        let startPointerX, startPointerY;
        let initialTranslateX, initialTranslateY;

        const startDrag = (e) => {
            // Prevent dragging if target is a button
            if (e.target.tagName === 'BUTTON') return;

            isDragging = true;
            // Get pointer coordinates (handle both mouse and touch)
            startPointerX = e.clientX || e.touches[0].clientX;
            startPointerY = e.clientY || e.touches[0].clientY;
            initialTranslateX = translateX;
            initialTranslateY = translateY;
            svgElement.style.cursor = 'grabbing';
            // Disable text selection on drag
            document.body.style.userSelect = 'none';
        };

        const duringDrag = (e) => {
            if (!isDragging) return;
            e.preventDefault(); // Prevent default touch actions like scrolling
            // Get current pointer coordinates
            const currentPointerX = e.clientX || e.touches[0].clientX;
            const currentPointerY = e.clientY || e.touches[0].clientY;

            // Calculate movement delta, scaled by current zoom level
            const dx = (currentPointerX - startPointerX) / scale;
            const dy = (currentPointerY - startPointerY) / scale;

            translateX = initialTranslateX + dx;
            translateY = initialTranslateY + dy;
            updateTransform();
        };

        const endDrag = () => {
            isDragging = false;
            svgElement.style.cursor = 'grab';
            document.body.style.userSelect = ''; // Re-enable text selection
        };

        // Mouse events for panning
        svgElement.addEventListener('mousedown', startDrag);
        svgElement.addEventListener('mousemove', duringDrag);
        svgElement.addEventListener('mouseup', endDrag);
        svgElement.addEventListener('mouseleave', endDrag);

        // Touch events for panning (for mobile devices)
        svgElement.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1) { // Only pan with one finger
                startDrag(e);
            }
        }, { passive: false }); // Use passive: false for preventDefault
        svgElement.addEventListener('touchmove', (e) => {
            if (e.touches.length === 1) {
                duringDrag(e);
            }
        }, { passive: false }); // Use passive: false for preventDefault
        svgElement.addEventListener('touchend', endDrag);
        svgElement.addEventListener('touchcancel', endDrag);


        document.getElementById("zoomIn").addEventListener("click", () => {
            if (scale < maxScale) {
                scale += zoomStep;
                updateTransform();
            }
        });

        document.getElementById("zoomOut").addEventListener("click", () => {
            if (scale > minScale) {
                scale -= zoomStep;
                updateTransform();
            }
        });

        // --- NEW JAVASCRIPT FOR JPL 01 PD-PLA STATUS ---
        function updateJPL01MapStatus() {
            const jpl01MapCircle = document.getElementById('jpl01-pdpla-map-circle');
            if (!jpl01MapCircle) {
                console.warn("JPL 01 PD-PLA map circle element not found.");
                return;
            }

            // Get the status color from localStorage
            const storedStatusColor = localStorage.getItem('jpl01OverallStatusColor');
            const storedStatusText = localStorage.getItem('jpl01OverallStatusText');

            if (storedStatusColor) {
                jpl01MapCircle.style.fill = storedStatusColor;
                // Update tooltip title
                jpl01MapCircle.querySelector('title').textContent = storedStatusText || 'Status JPL 01 PD-PLA';

                // Add/remove pulse animation
                if (storedStatusColor === 'red') {
                    jpl01MapCircle.classList.add('pulse-active');
                } else {
                    jpl01MapCircle.classList.remove('pulse-active');
                }
            } else {
                // Default to green if no status found (or if monitor page hasn't run yet)
                jpl01MapCircle.style.fill = '#00FF7F'; // Default green
                jpl01MapCircle.querySelector('title').textContent = 'JPL 01 PD-PLA: Status Tidak Diketahui';
                jpl01MapCircle.classList.remove('pulse-active');
            }
        }

        // Call update function when the map page loads
        document.addEventListener('DOMContentLoaded', updateJPL01MapStatus);

        // Listen for changes in localStorage from other tabs/windows
        window.addEventListener('storage', (event) => {
            if (event.key === 'jpl01OverallStatusColor' || event.key === 'jpl01OverallStatusText') {
                updateJPL01MapStatus();
            }
        });

        // Initial cursor style
        svgElement.style.cursor = 'grab';
    </script>
</body>
</html>