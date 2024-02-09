export default class TriColorBlend {

    constructor(clr1 = '#00C800', clr2 = '#FFFF00', clr3 = '#C80000')
    {
        this.clr1 = this.HexToRGB(clr1);
        this.clr2 = this.HexToRGB(clr2);
        this.clr3 = this.HexToRGB(clr3);
    }

    RGBToHex(r, g, b)
    {
        let bin = r << 16 | g << 8 | b;
        return (function (h) {
            return new Array(7 - h.length).join("0") + h
        })(bin.toString(16).toUpperCase())
    }

    HexToRGB(hex)
    {
        let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
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
