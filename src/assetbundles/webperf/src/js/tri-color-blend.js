export default class TriColorBlend {

    constructor(clr1 = {r: 0, g: 200, b: 0}, clr2 = {r: 255, g: 255, b: 0}, clr3 = {r: 200, g: 0, b: 0})
    {
        this.clr1 = clr1;
        this.clr2 = clr2;
        this.clr3 = clr3;
    }

    RGBToHex(r, g, b)
    {
        let bin = r << 16 | g << 8 | b;
        return (function (h) {
            return new Array(7 - h.length).join("0") + h
        })(bin.toString(16).toUpperCase())
    }

    colorFromPercentage(val)
    {
        let startColor = this.clr1;
        let endColor = this.clr2;
        if (val >= 50) {
            startColor = this.clr2;
            endColor = this.clr3;
            val = val - 50;
        }
        const multiplier = (val / 50);
        const r = Math.round(startColor.r + multiplier * (endColor.r - startColor.r));
        const g = Math.round(startColor.g + multiplier * (endColor.g - startColor.g));
        const b = Math.round(startColor.b + multiplier * (endColor.b - startColor.b));
        return '#' + this.RGBToHex(r,g,b);
    }
}
