var TypeReadObj  = new TypeRead();
TypeReadObj.RegisterEvent();

function TypeRead()
{
    var This = this;
    this.UriPath_ReadArticle = '/Article/Read/Single?Id=';
    
    this.RegisterEvent = function()
    {
        $('.LongText').click(function(){This.OpenRead(this.id);});
    };
    
    this.OpenRead = function(Id)
    {
        window.open(This.UriPath_ReadArticle+Id);
    };
}