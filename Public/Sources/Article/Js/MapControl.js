var TypeReadObj  = new TypeRead();
TypeReadObj.RegisterEvent();

function TypeRead()
{
    var This = this;
    this.UriPath_ReadArticle = '/Article/Read/Single?Id=';
    this.UriPath_TypeRead = '/Article/TypeRead/Basic?Id=';
    
    this.RegisterEvent = function()
    {
        $('.LongText').click(function(){This.OpenRead(this.id);});
        $('.MediumBoldText').click(function(){This.OpenReadType(this.id);});
    };
    
    this.OpenRead = function(Id)
    {
        window.open(This.UriPath_ReadArticle+Id);
    };
    
    this.OpenReadType = function(Id)
    {
        window.open(This.UriPath_TypeRead+Id);
    };
}