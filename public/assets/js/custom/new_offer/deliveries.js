class Deliveries{
    deliveries;
    index;
    constructor(string){
        this.deliveries = JSON.parse(string);
        this.__load();
        this.changeTo(this.deliveries[0].id);
    }
    changeTo(i){
        this.index = this.__getIndex(i)
        this.__refreshPayments();
    }
    __load(){
        let temp;
        $("#delivery").html("");
        for(var i=0;i<this.deliveries.length;i++){
            temp = `<option value="${this.deliveries[i].id}">${this.deliveries[i].name}</option>`;
            $("#delivery").append(temp);
        }
    }
    __refreshPayments(){
        let temp;
        $("#payments").html("");
        const p = this.deliveries[this.index].payments;
        for(var i=0;i<p.length;i++){
            temp = `<option value="${p[i].id}">${p[i].name}</option>`;
            $("#payments").append(temp);
        }
    }
    __getIndex(id){
        for(var i=0;i<this.deliveries.length;i++){
            if(this.deliveries[i].id == id){
                return i;
            }
        }
    }
}
