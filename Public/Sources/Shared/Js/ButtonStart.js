/*Global registry event*/
var ButtonStartObj = new ButtonStart(); ButtonStartObj.RegistryEvent();



/*Button start control*/
function ButtonStart() {
    var This = this;
    this.WindowLogin = null;    
    this.UriJson_LoginEmbeb = '/User/Login/Control';
    this.Show = false;
    
    this.RegistryEvent = function () {
        $(document).click(function (e) { This.Click(e);});
        $('.ButtonStartContainer').click(function () { This.HideMenu();});
        $('.StartOptionContainer').click(function () { This.ClickOption(this);});
        
    };

    this.Click = function (e) 
    {   
        if (e.target.id === 'ButtonStart')
        {
            if(This.Show)
            {
                This.HideMenu();
                This.Show = false;
            }
            else
            {
                This.ShowMenu();
                This.Show = true;
            }            
        }
        else 
        {
            This.HideMenu();
            This.Show = false;
        }
    };

    this.ShowMenu = function () {
        $("#MenuContainer").show();
    };

    this.HideMenu = function () {
        $("#MenuContainer").hide();
    };

    this.ClickOption = function (e) {
        switch (e.id) {
            case 'Login':
            {
                if (This.WindowLogin === null) This.WindowLogin = new WindowVirtual();
                This.WindowLogin.Init();
                This.WindowLogin.LoadContent(This.UriJson_LoginEmbeb);                
                break;
            }
            default:
            {

                break;
            }
        }
    };

    this.Refresh = function () {
        alert('refresh account');
    };
}