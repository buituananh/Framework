/*Create object and register event*/
var GroupPanelMgrObj = new GroupPanelManager();
GroupPanelMgrObj.RegisterEvent();


/*Manager group panel*/
function GroupPanelManager() {
    var This = this;
    this.UriJson_GetHelp = '/Help/Json_GetHelp';

    this.RegisterEvent = function () {
        $('.PanelContent').click(function () { This.ClickPanel(this) });
        $('#Back').click(function () { This.ClickBack(this) });
    };

    this.ClickPanel = function (e) {
        This.HideGroupPanelWraper();
        This.LoadPanel(e);
        This.ShowPanelDetail();
    };

    this.LoadPanel = function (e) {
        $.post
        (
            This.UriJson_GetHelp,
            {
            
            },
            function (Respond) {
                $('#ContentLoaded').text(Respond.Help.Content);
            }
        );
    };

    this.HideGroupPanelWraper = function () {
        $('#GroupPanelWraper').hide();
    };

    this.ShowGroupPanelWraper = function () {
        $('#GroupPanelWraper').show();
    };

    this.HidePanelDetail = function () {
        $('#PanelDetail').hide();
    };

    this.ShowPanelDetail = function () {
        $('#PanelDetail').show();
    };

    this.ClickBack = function () {
        This.HidePanelDetail();
        This.ShowGroupPanelWraper();
    };
}