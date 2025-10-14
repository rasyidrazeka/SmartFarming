<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleTemperature_sensor2" data-original="Soil Temperature">Soil Temperature</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeTemperature_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=12&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleHumidity_sensor2" data-original="Soil Humidity">Soil Humidity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeHumidity_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=13&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleConductivity_sensor2" data-original="Soil Conductivity">Soil Conductivity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeConductivity_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=14&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titlepH_sensor2" data-original="Soil pH">Soil pH</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePh_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=15&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleNitrogen_sensor2" data-original="Soil Nitrogen">Soil Nitrogen</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeNitrogen_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=16&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titlePhosphorus_sensor2" data-original="Soil Phosphorus">Soil Phosphorus</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePhosphorus_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=17&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titlePotassium_sensor2" data-original="Soil Potassium">Soil Potassium</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePotassium_sensor2"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=18&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const iframeIds = [
        'grafanaIframeTemperature_sensor2',
        'grafanaIframeHumidity_sensor2',
        'grafanaIframeConductivity_sensor2',
        'grafanaIframePh_sensor2',
        'grafanaIframeNitrogen_sensor2',
        'grafanaIframePhosphorus_sensor2',
        'grafanaIframePotassium_sensor2'
    ];

    let loadedCount = 0;
    const totalIframes = iframeIds.length;

    function showAllIframes() {
        iframeIds.forEach(id => {
            const iframe = document.getElementById(id);
            if (iframe) iframe.style.display = 'block';
        });
    }

    iframeIds.forEach(id => {
        const iframe = document.getElementById(id);
        if (iframe) {
            iframe.onload = function() {
                loadedCount++;
                if (loadedCount === totalIframes) {
                    showAllIframes();
                }
            };
        }
    });
</script>
