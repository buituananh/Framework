var flashvars = 
{
    importxmlpath : "http://sea.blizzard.com/static/_content/en-sg/frontpage.xml",
    mediahostpath : "http://sea.media.blizzard.com/blizzard/_flash/"
};
var params = 
{
    bgcolor : "#010d16",
    quality : "autohigh",		
    wmode : "transparent",
    base : "http://sea.blizzard.com/static/_flash/",
    allowScriptAccess : "always"
};
swfobject.embedSWF("http://sea.media.blizzard.com/blizzard/_flash/header.swf", "flashHeader", "100%", "570", "9.0.0", false, flashvars, params, {});