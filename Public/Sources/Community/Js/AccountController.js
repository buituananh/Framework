/*Create object*/
var MenuMgrObj = new MenuManager();
var AccountMgrObj = new AccountManager();

/*Create observer and run*/
var ObserverObj = new Observer();
ObserverObj.Run();

/*Observer for all event*/
function Observer() {
    this.Run = function() {
        MenuMgrObj.RegistryEvent();
        AccountMgrObj.ResgistryEvent();
    };
}

/*Manager menu in director*/
function MenuManager() {
    var This = this;
    this.OptionSelected = null;
    this.UserStatus = null;
    this.UriJson_GetLoginStatus = '/User/State/Json_Basic';
    this.UriJson_Logout = '/User/Logout/Json_Basic';

    this.RegistryEvent = function()
    {
        This.RegisterEventElement();
        This.Init();
    };

    this.RegisterEventElement = function () {
        $('.Service').click(function () { This.ClickOption(this); });
        $('.Service').mouseover(function () { This.HoverInOption(this) ;});
        $('.Service').mouseout(function () { This.HoverOutOptionByMouse(this) ;});
    };

    this.Init = function () {
        $.post(
            This.UriJson_GetLoginStatus,
            {},
            function (Respond) {
                
                if (Respond.Result === undefined || !Respond.Result || !Respond.Status.Logging) {
                    /*Init interface login*/                    
                    This.InitLoginUi();                    
                }
                else {
                    /*Init interface logout*/
                    This.UserStatus = Respond.Status;
                    This.InitLogOutUi();
                }
            }
        );
    };

    this.InitLoginUi = function()
    {
        $('#Login').show();
        $('#AddUser').show();
        $('#Logout').hide();
        $('#Personal').hide();
        This.DestroyUserContainer();

    };

    this.InitLogOutUi = function () {
        $('#Login').hide();
        $('#AddUser').hide();
        $('#Logout').show();
        $('#Personal').show();
        This.InitUserContainer();
    };

    this.InitUserContainer = function () {
        $('#UserName').text(This.UserStatus.UserName);
        $('#Avatar').attr('src', This.UserStatus.LinkAvatar);
        $('#UserContainer').show();
    };

    this.DestroyUserContainer = function () {
        $('#UserName').text('');
        $('#Avatar').attr('src', '');
        $('#UserContainer').hide();
    };

    this.ClickOption = function(e)
    {
        This.SelectOption(e);
        switch (e.id) {
            case 'Home':
            {
                window.location.replace('/');
                break;
            }
            case 'AddUser':
            {
                AccountMgrObj.CheckWindowLogin();
                break;
            }
            case 'Login':
            {
                AccountMgrObj.CheckWindowLogin();
                break;
            }
            case 'Personal':
                {
                    window.location.replace('/Account/Personal');
                    break;
                }
            case 'Logout':
            {
                $.post
                (
                    This.UriJson_Logout,
                    {},
                    function(data)
                    {
                        This.Init();
                    }
                );
                break;
            }
            case 'AddUser':
            {

                break;
            }
            default:
            {
                break;
            }
        }
    };

    this.SelectOption = function(e)
    {
        This.HoverOutOption(This.OptionSelected);
        This.HoverInOption(e);
        This.OptionSelected = e;
    };

    this.HoverInOption = function (e) {
        $(e).css('background', '#C9C9C0');
        $(e).css('color', '#FFF');
    };

    this.HoverOutOption = function (e) {
        $(e).css('background', '#EBEBEB');
        $(e).css('color', '#333');
    };

    this.HoverOutOptionByMouse = function (e) {
        if (e === null) return;
        if (this.OptionSelected !== null) if (e.id === this.OptionSelected.id) return;
        this.HoverOutOption(e);
    };
}

/*Manager account*/
function AccountManager() {
    var This = this;
    this.WindowLogin = null;
    this.UriEmbeb_LoginUi = '/User/Login/Control';

    this.ResgistryEvent = function () {

    };

    this.InitWindowLogin = function () {
        if (This.WindowLogin === null) {
            This.WindowLogin = new WindowVirtual();
            This.WindowLogin.RegisterClose(MenuMgrObj.Init);
        }
        This.WindowLogin.Init();
        This.WindowLogin.LoadContent(This.UriEmbeb_LoginUi);      
    };

    this.CheckWindowLogin = function () {        
        This.InitWindowLogin();
    };

    this.CloseWindowLogin = function () {
        WindowMgrObj.PreCloseWindow();
        WindowMgrObj.CloseWindow();
    };
}
