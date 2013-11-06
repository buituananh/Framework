/*
 * Timer version 1.0 - Tuan Anh - AOF
 */
function timer(idTimer)
{
    getAndShowTimeonSys();
    function getAndShowTimeonSys()
    {
        var today = new Date();
        var timeZoneUTC = today.getTimezoneOffset()/-60;
        var year = today.getFullYear();
        var month = today.getMonth() + 1;
        var date = today.getDate();
        var day = today.getDay();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        timeZoneUTC = modifiTimeZone(timeZoneUTC);
        month = modifiTime(month);
        date = modifiTime(date);
        day = modifiDay(day);
        h = modifiTime(h);
        m = modifiTime(m);
        s = modifiTime(s);
        document.getElementById(idTimer).innerHTML="UTC"+timeZoneUTC+" | "+year+"-"+month+"-"+date+" | "+day+" | "+h+":"+m+":"+s;
        setTimeout(function(){getAndShowTimeonSys();},1000);
    }
    
    //modifi time
    function modifiTime(time)
    {
        if (time < 10) { time = "0" + time; }
        return time;
    }
    function modifiTimeZone(timeZone)
    {
        if (timeZone >= 0) { timeZone = "+" + timeZone; }
        else { timeZone = "-" + timeZone ;}
        return timeZone;
    }
    function modifiDay(day)
    {
        switch(day)
        {
            case 1: { day = "Mon"; break;}
            case 2: { day = "Tue"; break;}
            case 3: { day = "Wed"; break;}
            case 4: { day = "Thu"; break;}
            case 5: { day = "Fri"; break;}
            case 6: { day = "Sat"; break;}
            case 0: { day = "Sun"; break;}
        }
        return day;
    }
    
}