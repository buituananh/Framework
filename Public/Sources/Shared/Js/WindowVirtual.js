/**/
function WindowVirtual() {
    var This = this;
    this.IsShow = false;
    this.IsOpen = false;
    this.CloseActive = null;

    this.RegisterEvent = function () {
        $('#WindowClose').click(function () { This.Close(); });
    }
    
    this.Init = function () {
        /*Create screen*/
        $(document.body).prepend('<div class="Screen" id="Screen"></div>');
        /*Create window container*/
        $('#Screen').append('<div class="WindowContainer" id="WindowContainer"></div>');
        /*Create controller for window*/
        $('#WindowContainer').append('<div class="WindowController" id="WindowController"></div>');
        $('#WindowController').append('<div class="WindowControllerE" id="WindowClose"></div>');
        $('#WindowClose').append('<img src="/Framework/Icon/Standard/Delete.png" >');
        /*Create empty content window*/
        $('#WindowContainer').append('<div class="WindowContent" id="WindowContent"></div>');                
        /*Registry event*/
        This.RegisterEvent();
    }

    this.LoadContent = function (UriEmbeb) {
        $('#WindowContent').empty();
        /*Waiting load*/
        This.TurnOnWaiting();
        /*Start load*/
        $.post
        (
            UriEmbeb,
            {},
            function (Respond) {
                /*End load*/
                This.TurnOffWaiting();
                $('#WindowContent').html(Respond).fadeIn(3000);
                This.WindowOpen = true;                                
            }
        );        
    }

    this.Show = function () {
        $('#Screen').show();
    }

    this.Hide = function () {
        $('#Sreen').hide();
    }

    this.Close = function () {
        $('#Screen').remove();
        This.WindowOpen = false;
        if (This.CloseActive !== null) This.CloseActive();
    }

    this.RegisterClose = function (CloseActive) {
        This.CloseActive = CloseActive;
    }

    this.TurnOnWaiting = function () {
        $('#WindowContent').append('<div class="WindowRespond" id="WindowRespond.Wait" ></div>');
        $('#WindowRespond\\.Wait').append('<img src="/Framework/Gif/Waiting002.gif"></img>');
    }

    this.TurnOffWaiting = function () {
        $('#WindowRespond\\.Wait').remove();
    }
}