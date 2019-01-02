// This code is run after all plugins have initialized
BOOMR.init({
    beacon_url: "/webperf/metrics/beacon",
    log: null,
});
BOOMR.t_end = new Date().getTime();
