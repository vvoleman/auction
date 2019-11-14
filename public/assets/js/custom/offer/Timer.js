class Timer{
    final_time;
    interval;
    el;
    constructor(unix,id){
        this.final_time = unix;
        this.el = "#"+id;
    }
    start(){
        this.interval = setInterval(()=>{
            let timeleft = this._timeLeft(new Date().getTime());
            console.log(timeleft);
            if(timeleft == null){
                this.__timerEnded();
                return;
            }
            $(this.el).text(this._toString(timeleft));
        },300);
    }
    _timeLeft(time){
        console.log(time,this.final_time);
        return (time > this.final_time) ? null : this.final_time-time;
    }
    _toString(time){
        const arr = [
            3600000,60000,1000
        ];
        let res = [];
        for(var i=0;i<arr.length;i++){
            res[0] = Math.floor(time/arr[i]);
            time %= arr[i];
        }
        return res[0]+":"+res[1]+":"+res[2];

    }
    __timerEnded(){
        console.log("Ukončuji");
        clearInterval(this.interval);

    }

}
