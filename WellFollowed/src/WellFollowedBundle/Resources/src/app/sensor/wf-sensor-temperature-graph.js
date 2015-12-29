angular.module('wellFollowed').directive('wfSensorTemperatureGraph', function() {
   return {
       restrict: 'E',
       templateUrl: 'sensor/wf-sensor-temperature-graph.html',
       require: '^wfSensor',
       link: function(scope, element, attributes, wfSensor) {

           var n = 243,
               duration = 750,
               now = new Date(Date.now() - duration),
               data = d3.range(n).map(function() { return 0; });

           var margin = {top: 6, right: 0, bottom: 20, left: 40},
               width = element.width() - margin.right,
               height = 120 - margin.top - margin.bottom;

           var x = d3.time.scale()
               .domain([now - (n - 2) * duration, now - duration])
               .range([0, width]);

           var y = d3.scale.linear()
               .range([height, 0]);

           var line = d3.svg.line()
               .interpolate("basis")
               .x(function(d, i) { return x(now - (n - 1 - i) * duration); })
               .y(function(d, i) { return y(d); });

           var svg = d3.select(element[0]).append("p").append("svg")
               .attr("width", width + margin.left + margin.right)
               .attr("height", height + margin.top + margin.bottom)
               .style("margin-left", -margin.left + "px")
               .append("g")
               .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

           svg.append("defs").append("clipPath")
               .attr("id", "clip")
               .append("rect")
               .attr("width", width)
               .attr("height", height);

           var axis = svg.append("g")
               .attr("class", "x axis")
               .attr("transform", "translate(0," + height + ")")
               .call(x.axis = d3.svg.axis().scale(x).orient("bottom"));

           var path = svg.append("g")
               .attr("clip-path", "url(#clip)")
               .append("path")
               .datum(data)
               .attr("class", "line");

           var transition = d3.select({}).transition()
               .duration(750)
               .ease("linear");

           d3.select(window)
               .on("resize", function() {

               });
           //d3.select(window)
           //    .on("scroll", function() { ++count; });

           var session = wfSensor.getWsSession();

           session.subscribe('sensor/data/' + scope.sensor.name, function(uri, payload) {

               scope.$apply(function() {
                   scope.currentTemp = payload.msg.val;
               });
               //data.push(payload.msg.val);
               //path.transition()
               //    .attr("transform", "translate(" + x(now - (n - 1) * duration) + ")");
               // update the domains
               now = new Date(payload.msg.date);
               x.domain([now - (n - 2) * duration, now - duration]);
               y.domain([0, d3.max(data)]);

               // push the accumulated count onto the back, and reset the count
               data.push(payload.msg.val);
               //count = 0;

               // redraw the line
               svg.select(".line")
                   .attr("d", line)
                   .attr("transform", null);

               // slide the x-axis left
               axis.call(x.axis);

               // slide the line left
               path.transition()
                   .attr("transform", "translate(" + x(now - (n - 1) * duration) + ")");

               // pop the old data point off the front
               data.shift();
           });

           //(function tick() {
           //    transition = transition.each(function() {
           //
           //        // update the domains
           //        now = new Date();
           //        x.domain([now - (n - 2) * duration, now - duration]);
           //        y.domain([0, d3.max(data)]);
           //
           //        // push the accumulated count onto the back, and reset the count
           //        //data.push(Math.min(30, count));
           //        //count = 0;
           //
           //        // redraw the line
           //        svg.select(".line")
           //            .attr("d", line)
           //            .attr("transform", null);
           //
           //        // slide the x-axis left
           //        axis.call(x.axis);
           //
           //        // slide the line left
           //        //path.transition()
           //        //    .attr("transform", "translate(" + x(now - (n - 1) * duration) + ")");
           //
           //        // pop the old data point off the front
           //        data.shift();
           //
           //    }).transition().each("start", tick);
           //})();


           //var n = 40,
           //    random = d3.random.normal(0, .2);
           //
           //function chart(domain, interpolation, tick) {
           //    var data = d3.range(n).map(random);
           //
           //    var margin = {top: 6, right: 0, bottom: 6, left: 40},
           //        width = element.width() - margin.right,
           //        height = 120 - margin.top - margin.bottom;
           //
           //    var x = d3.scale.linear()
           //        .domain(domain)
           //        .range([0, width]);
           //
           //    var y = d3.scale.linear()
           //        .domain([-1, 1])
           //        .range([height, 0]);
           //
           //    var line = d3.svg.line()
           //        .interpolate(interpolation)
           //        .x(function(d, i) { return x(i); })
           //        .y(function(d, i) { return y(d); });
           //
           //    var svg = d3.select(element[0]).append("p").append("svg")
           //        .attr("width", width + margin.left + margin.right)
           //        .attr("height", height + margin.top + margin.bottom)
           //        .style("margin-left", -margin.left + "px")
           //        .append("g")
           //        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
           //
           //    svg.append("defs").append("clipPath")
           //        .attr("id", "clip")
           //        .append("rect")
           //        .attr("width", width)
           //        .attr("height", height);
           //
           //    svg.append("g")
           //        .attr("class", "y axis")
           //        .call(d3.svg.axis().scale(y).ticks(5).orient("left"));
           //
           //    var path = svg.append("g")
           //        .attr("clip-path", "url(#clip)")
           //        .append("path")
           //        .datum(data)
           //        .attr("class", "line")
           //        .attr("d", line);
           //
           //    tick(path, line, data, x);
           //}
           //
           //var transition = d3.select({}).transition()
           //    .duration(750)
           //    .ease("linear");
           //
           //chart([1, n - 2], "basis", function tick(path, line, data, x) {
           //    transition = transition.each(function() {
           //
           //        // push a new data point onto the back
           //        data.push(random());
           //
           //        // redraw the line, and then slide it to the left, and repeat indefinitely
           //        path
           //            .attr("d", line)
           //            .attr("transform", null)
           //            .transition()
           //            .attr("transform", "translate(" + x(0) + ")");
           //
           //        // pop the old data point off the front
           //        data.shift();
           //
           //    }).transition().each("start", function() { tick(path, line, data, x); });
           //});

           //var w = element.width();
           //
           //var margin = {top: 20, right: 20, bottom: 30, left: 50},
           //    width = element.width() - margin.left - margin.right,
           //    height = 300 - margin.top - margin.bottom;
           //
           //var parseDate = d3.time.format("%d-%b-%y").parse;
           //
           //var x = d3.time.scale()
           //    .range([0, width]);
           //
           //var y = d3.scale.linear()
           //    .range([height, 0]);
           //
           //var xAxis = d3.svg.axis()
           //    .scale(x)
           //    .orient("bottom");
           //
           //var yAxis = d3.svg.axis()
           //    .scale(y)
           //    .orient("left");
           //
           //var line = d3.svg.line()
           //    .x(function(d) { return x(d.date); })
           //    .y(function(d) { return y(d.val); });
           //
           //var svg = d3.select(element[0]).append("svg")
           //    .attr("width", width + margin.left + margin.right)
           //    .attr("height", height + margin.top + margin.bottom)
           //    .append("g")
           //    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
           //
           ////d3.tsv("bundles/wellfollowed/data.tsv", function(error, data) {
           //scope.$watch('data', function(data) {
           //    //if (error) throw error;
           //
           //    if (!!data) {
           //        data.forEach(function (d) {
           //            d.date = parseDate(d.date);
           //            d.val = +d.val;
           //        });
           //
           //        x.domain(d3.extent(data, function (d) {
           //            return d.date;
           //        }));
           //        y.domain(d3.extent(data, function (d) {
           //            return d.val;
           //        }));
           //
           //        svg.append("g")
           //            .attr("class", "x axis")
           //            .attr("transform", "translate(0," + height + ")")
           //            .call(xAxis);
           //
           //        svg.append("g")
           //            .attr("class", "y axis")
           //            .call(yAxis)
           //            .append("text")
           //            .attr("transform", "rotate(-90)")
           //            .attr("y", 6)
           //            .attr("dy", ".71em")
           //            .style("text-anchor", "end")
           //            .text("Température");
           //
           //        svg.append("path")
           //            .datum(data)
           //            .attr("class", "line")
           //            .attr("d", line);
           //    }
           //
           //}, true);

       }
   };
});