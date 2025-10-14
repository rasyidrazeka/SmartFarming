<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleTemperature_sensor3" data-original="Soil Temperature">Soil Temperature</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeTemperature_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=12&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titleHumidity_sensor3" data-original="Soil Humidity">Soil Humidity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeHumidity_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=13&__feature.dashboardSceneSolo"
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
                <h6 id="titleConductivity_sensor3" data-original="Soil Conductivity">Soil Conductivity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeConductivity_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=14&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titlepH_sensor3" data-original="Soil pH">Soil pH</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePh_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=15&__feature.dashboardSceneSolo"
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
                <h6 id="titleNitrogen_sensor3" data-original="Soil Nitrogen">Soil Nitrogen</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeNitrogen_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=16&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 id="titlePhosphorus_sensor3" data-original="Soil Phosphorus">Soil Phosphorus</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePhosphorus_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=17&__feature.dashboardSceneSolo"
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
                <h6 id="titlePotassium_sensor3" data-original="Soil Potassium">Soil Potassium</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePotassium_sensor3"
                        src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=3&var-sensor_dht=1&refresh=5s&editIndex=2&theme=light&panelId=18&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const iframeIds = [
        'grafanaIframeTemperature_sensor3',
        'grafanaIframeHumidity_sensor3',
        'grafanaIframeConductivity_sensor3',
        'grafanaIframePh_sensor3',
        'grafanaIframeNitrogen_sensor3',
        'grafanaIframePhosphorus_sensor3',
        'grafanaIframePotassium_sensor3'
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
