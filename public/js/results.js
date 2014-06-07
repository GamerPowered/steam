var transformProp = Modernizr.prefixed('transform');

function Carousel3D ( el ) {
    this.element = el;

    this.rotation = 0;
    this.panelCount = 0;
    this.theta = 0;
    this.speed = 1;
}

Carousel3D.prototype.modify = function() {

    var panel, angle, i;

    this.panelSize = this.element['offsetWidth'];
    this.rotateFn = 'rotateY';
    this.theta = 360 / this.panelCount;

    // do some trig to figure out how big the carousel
    // is in 3D space
    this.radius = Math.round( ( this.panelSize / 2) / Math.tan( Math.PI / this.panelCount ) );

    theta_pass = this.theta;
    radius_pass = this.radius;
    rotateFn_pass = this.rotateFn;
    speed_pass = this.speed;

    $(this.element).children().each(function(i, panel) {
        angle = theta_pass * i;
        // rotate panel, then push it out in 3D space
        $(panel).css(transformProp, rotateFn_pass + '(' + angle + 'deg) translateZ(' + radius_pass + 'px)');
    });

    // adjust rotation so panels are always flat
    this.rotation = Math.round( this.rotation / this.theta ) * this.theta;

    this.transform();

};

Carousel3D.prototype.transform = function() {
    // push the carousel back in 3D space,
    // and rotate it
    $(this.element).css(transformProp, 'translateZ(-' + this.radius + 'px) ' + this.rotateFn + '(' + this.rotation + 'deg)');
};



var init = function() {
    var carousel = new Carousel3D( document.getElementById('carousel') );

    // populate on startup
    carousel.panelCount = $('#carousel').find('img').length
    carousel.modify();

    $('body').addClass('ready');

    var t_interval = 1;
    var transforms = 0;

    var last_interval = 200;

    var inertia_factor = 0.00003;
    var inertia_dampening = 0.0;

    var slow_factor = 50;

    var timeoutfunc = function() {
        carousel.rotation -= carousel.theta;
        carousel.transform();

        inertia_dampening = (1.01 * inertia_dampening) + (slow_factor * slow_factor * inertia_factor);

        t_interval = (last_interval - (last_interval - (t_interval * 1 + inertia_dampening)));

        transforms++;
        carousel.speed = (last_interval - (last_interval - (t_interval * 1 + inertia_dampening)));

        console.log(transforms);
        if (t_interval < last_interval) {
            setTimeout(timeoutfunc, t_interval)
        } else {
            $('#carousel').fadeOut(400, function() {
                $('#game').fadeIn(2000);
                $('#gametitle').fadeTo(2000, 1);
                $('#players').fadeTo(2000, 1);
            });
        }
    };

    carousel.transform();
    $(carousel.element).waitForImages(function() {
        $(carousel.element).children().fadeTo(400, 1);
        timeoutfunc();
    });


};

$(document).ready(init());
