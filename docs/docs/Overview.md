# Webperf Overview

Webperf uses [Real User Measurement](https://en.wikipedia.org/wiki/Real_user_monitoring) (RUM) captured anonymously from actual visitors to your website to profile its performance. In this way, Webperf passively gathers and monitors how your website performs on real-world devices used by real-world users.

Webperf also gathers Craft specific information such as database queries, Twig rendering time, memory used, and overall TTFB (Time To First Byte) performance timings. Webperf will also record any front JavaScript errors as well as Craft CMS errors in one place for ease of discovery.

Webperf then presents this performance information in concise graphs that give you insight into how your website performs. Webperf even provides you with bullet-pointed recommendations on how you can fix any performance problems that are found. And [performance affects conversions](https://www.cloudflare.com/learning/performance/more/website-performance-conversion-rates/) as well as user experience.

Webperf leverages the the performance profiling that web browsers & Craft CMS already do. It has been optimized to minimize the [Observer Effect](https://en.wikipedia.org/wiki/Observer_effect_(information_technology)), collecting data without impacting performance.

Webperf uses the battle-tested [Boomerang](https://akamai.github.io/boomerang/) JavaScript from Akamai, loaded asynchronously in a non-blocking iframe. Boomerang uses performance information from the user's browser via the [Navigation Timing API](https://developer.mozilla.org/en-US/docs/Web/API/Navigation_timing_API).

Brought to you by [nystudio107](https://nystudio107.com)
