class FormChanges{
    og;
    constructor(og){
        this.og = og;

    }
    somethingNew(changed){
        return !_.isEqual(changed,this.og);
    }
}
