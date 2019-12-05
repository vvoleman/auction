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
        console.log(this.final_time,time);
        return (time > this.final_time) ? null : this.final_time-time;
    }
    _toString(time){
            var timeLeft = time/1000;

            var hours = Math.floor((timeLeft / 3600));
            var minutes = Math.floor((timeLeft - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (hours * 3600) - (minutes * 60)));
  
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }

        return hours+":"+minutes+":"+seconds;

    }
    __timerEnded(){
        console.log("Ukončuji");
        window.location.reload();
        clearInterval(this.interval);

    }

}
