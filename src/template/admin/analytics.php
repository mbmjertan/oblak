<div class="container">
    <div class="analyticsMap">
        <div class="row">
            <div class="col s12 m4">
                <div class="card grey darken-3 container shadow-z-3">
                    <span class="card-title white-text">Broj posjeta ikad</span>
                    <h2 class="white-text"><?php if (isset($data)) {
                            echo $data['numberOfVisitsEver'];
                        } ?></h2>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3 container shadow-z-3">
                    <span class="card-title white-text">Broj posjeta u 30 dana</span>
                    <h2 class="white-text"><?php if (isset($data)) {
                            echo $data['lastMonthVisits'];
                        } ?></h2>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3 container shadow-z-3">
                    <span class="card-title white-text">Broj posjeta u 24 sata</span>
                    <h2 class="white-text"><?php if (isset($data)) {
                            echo $data['lastDayVisits'];
                        } ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m4">
                <div class="card grey darken-3 container shadow-z-3">
                    <span class="card-title white-text">Najposjećenije ikad</span>
                    <p class="white-text"><?php if (isset($data)) {
                            foreach ($data['uriMapMostVisitsEver'] as $visit) {
                                echo '<a href="' . $visit['uri'] . '" class="light-blue-text" style="text-transform:none !important;">' . $visit['uri'] . '</a> (' . $visit['COUNT(*)'] . ')';
                                echo '<br>';
                            }
                        } ?></p>
                    </span>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3 container shadow-z-3">
                    <span class="card-title white-text">Najposjećenije u 24 sata</span>
                    <p class="white-text"><?php if (isset($data)) {
                            foreach ($data['uriMapMostVisitsDay'] as $visit) {
                                echo '<a href="' . $visit['uri'] . '" class="light-blue-text" style="text-transform:none !important;">' . $visit['uri'] . '</a> (' . $visit['COUNT(*)'] . ')';
                                echo '<br>';
                            }
                        } ?></p>
                    </span>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-1 container shadow-z-3">
                    <span class="card-title white-text">Alati</span>
                    <p class="white-text"><a href="?export=html" class="light-blue-text"
                                             style="text-transform:none !important;">Prikaži sirove
                            podatke</a><br><br><a href="?export=csv" class="light-blue-text"
                                                  style="text-transform:none !important;">Izvezi u CSV datoteku</a></p>

                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
