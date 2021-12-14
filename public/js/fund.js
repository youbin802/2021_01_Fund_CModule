class Fund {
    constructor(bar, percent) {
        this.percent = percent; //펀드 데이터
        this.startDraw();
        this.bar = bar;
    }

    startDraw() {
        let step = this.percent / 30;
        console.log(step);
        let now = 0;
        const timer = setInterval(() => {
            this.render(now);
            now += step;
            if (now >= this.percent) {
                now = this.percent;
                this.render(now);
                clearInterval(timer);
            }
        }, 1000 / 30);
    }

    render(value) {
        value = Math.round(value * 100) / 100;
        this.bar.style.width = `${value}%`;
    }
}