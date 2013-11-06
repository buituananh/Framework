function Animal(Name)
{
    this.Name = 'Animal '+Name;
    this.Son = [];
}
Animal.prototype.HaveSon = function(Son)
{
    alert(Son);
    var NewSon = new Animal(Son + ' Animal '+this.name);
    this.Son.push(NewSon);
};
Animal.prototype.ListSon = function()
{
    return this.Son;
};
Animal.prototype.GetName = function()
{
    return this.Name;
};
Cat.prototype = new Animal()
{
    
};
Cat.prototype.constructor = Cat;
function Cat(Name)
{
    Animal.prototype.HaveSon.call(this, Name);
    alert('Cat say: meo moe');
}
Cat.prototype.GetName = function()
{
    return this.Name;
};

var SomeAnimal = new Animal('Piggy');
document.write(SomeAnimal.GetName());
var MyCat = new Cat('Lulu');
document.write(MyCat.GetName());
