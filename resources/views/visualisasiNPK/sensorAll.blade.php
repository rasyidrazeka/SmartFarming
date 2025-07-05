<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Temperature</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeTemperature_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=27&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Humidity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeHumidity_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=28&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Conductivity</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeConductivity_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=29&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil pH</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePh_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=30&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Nitrogen</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframeNitrogen_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=31&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Phosphorus</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePhosphorus_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=32&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <h6>Soil Potassium</h6>
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaIframePotassium_sensorAll"
                        src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&refresh=10s&theme=light&panelId=33&__feature.dashboardSceneSolo"
                        allowfullscreen style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const iframeIds = [
        'grafanaIframeTemperature_sensorAll',
        'grafanaIframeHumidity_sensorAll',
        'grafanaIframeConductivity_sensorAll',
        'grafanaIframePh_sensorAll',
        'grafanaIframeNitrogen_sensorAll',
        'grafanaIframePhosphorus_sensorAll',
        'grafanaIframePotassium_sensorAll'
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
