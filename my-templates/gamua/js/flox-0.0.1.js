$("document").ready(function () {
    var floxUri = "https://www.flox.cc";
    var gameId = "EQxJL9PwsSqIm0Eu";
    var gameKey = "rhHwmBONEFg7K6oK";

    try {
        executeAnalyticsPost(floxUri, gameId, gameKey);
    } catch (e) {
        //ignore errors in production
    }
});

function executeAnalyticsPost(floxUri, gameId, gameKey) {
    var url = floxUri + "/api/games/" + gameId + "/.analytics";
    var xFloxHeader = createXFloxHeader(gameKey);
    var data = createAnalyticsPost();

    $.support.cors = true;

    $.ajax({
        type: "POST",
        url: url,
        crossDomain: true,
        data: JSON.stringify(data),
        dataType: "json",
        beforeSend: function (jqXHR) {
            jqXHR.setRequestHeader("X-Flox", JSON.stringify(xFloxHeader));
        },
        success: function (responseData, textStatus, jqXHR) {
            //console.log("Request successful.");
        },
        error: function (responseData, textStatus, errorThrown) {
            console.log("Flox request failed.");
            console.log("Response: " + JSON.stringify(responseData));
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function createAnalyticsPost() {
    return  {
        "startTime": formatAsXmlDateTime(new Date()),
        "gameVersion": "0.0.1",
        "languageCode": "en",
        "deviceInfo": {}
    };
}

function createXFloxHeader(gameKey) {
    var sdk = {};
    sdk.type = "js";
    sdk.version = "0.0.1";

    var player = {};
    player.id = createUUID();
    player.authType = "guest";

    var xFloxHeader = {};
    xFloxHeader.sdk = sdk;
    xFloxHeader.player = player;
    xFloxHeader.dispatchTime = formatAsXmlDateTime(new Date());
    xFloxHeader.gameKey = gameKey;
    xFloxHeader.bodyCompression = "none";

    return xFloxHeader;
}

function createUUID() {
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var length = 16;

    var result = "";
    for (var i = 0; i < length; i++)
        result += chars.charAt(Math.floor(Math.random() * chars.length));

    return result;
}

function formatAsXmlDateTime(date) {
    function pad(n, l) {
        var s = n.toString();
        return s.length < l ? '0' + s : s;
    }

    var yyyy = date.getFullYear();
    var mm1 = pad(date.getMonth() + 1, 2);
    var dd = pad(date.getDate(), 2);
    var hh = pad(date.getHours(), 2);
    var mm2 = pad(date.getMinutes(), 2);
    var ss = pad(date.getSeconds(), 2);
    var SSS = pad(date.getMilliseconds(), 3);

    return yyyy + '-' + mm1 + '-' + dd + 'T' + hh + ':' + mm2 + ':' + ss + '.' + SSS + 'Z';
}
