/*高斯模糊*/
<style>
.blur {
    filter: blur(10px);
    -webkit-filter: blur(10px);
    -moz-filter: blur(10px);
    -ms-filter: blur(10px);
    -o-filter: blur(10px);
}
</style>

/*Loading*/
<div class="loading">
	<div class="cssload-circle">
		<div class="cssload-inner"></div>
	</div>
	<div class="cssload-circle">
		<div class="cssload-inner"></div>
	</div>
	<div class="cssload-circle">
		<div class="cssload-inner"></div>
	</div>
	<div class="cssload-circle">
		<div class="cssload-inner"></div>
	</div>
	<div class="cssload-circle">
		<div class="cssload-inner"></div>
	</div>
</div>

<script>
    $(function(){
        $(document).pjax("a", '.container', {fragment:'.container', timeout:6000});
        $(document).on('pjax:send', function() {
            $('.loading').show();
            $('.container').addClass('blur');
        });
        $(document).on('pjax:complete', function() {
            $('.loading').hide();
            $('.container').removeClass('blur');
        });
    });
</script>

<style>
.loading {
    display: none;
    width: 180px;
    height: 180px;
    border-radius: 100%;
    position: absolute;
    left: 50%;
    margin-left: -90px;
    top: 50%;
    margin-top: -90px;
}

.cssload-circle {
    width: 100%;
    height: 100%;
    position: absolute;
}

.cssload-circle .cssload-inner {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    border: 9px solid rgba(0, 255, 170, 0.7);
    border-right: none;
    border-top: none;
    background-clip: padding;
    box-shadow: inset 0px 0px 18px rgba(0, 255, 170, 0.15);
}

.cssload-circle:nth-of-type(0) {
    transform: rotate(0deg);
    -o-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
}

.cssload-circle:nth-of-type(0) .cssload-inner {
    animation: cssload-spin 1.5s infinite linear;
    -o-animation: cssload-spin 1.5s infinite linear;
    -ms-animation: cssload-spin 1.5s infinite linear;
    -webkit-animation: cssload-spin 1.5s infinite linear;
    -moz-animation: cssload-spin 1.5s infinite linear;
}

.cssload-circle:nth-of-type(1) {
    transform: rotate(70deg);
    -o-transform: rotate(70deg);
    -ms-transform: rotate(70deg);
    -webkit-transform: rotate(70deg);
    -moz-transform: rotate(70deg);
}

.cssload-circle:nth-of-type(1) .cssload-inner {
    animation: cssload-spin 1.5s infinite linear;
    -o-animation: cssload-spin 1.5s infinite linear;
    -ms-animation: cssload-spin 1.5s infinite linear;
    -webkit-animation: cssload-spin 1.5s infinite linear;
    -moz-animation: cssload-spin 1.5s infinite linear;
}

.cssload-circle:nth-of-type(2) {
    transform: rotate(140deg);
    -o-transform: rotate(140deg);
    -ms-transform: rotate(140deg);
    -webkit-transform: rotate(140deg);
    -moz-transform: rotate(140deg);
}

.cssload-circle:nth-of-type(2) .cssload-inner {
    animation: cssload-spin 1.5s infinite linear;
    -o-animation: cssload-spin 1.5s infinite linear;
    -ms-animation: cssload-spin 1.5s infinite linear;
    -webkit-animation: cssload-spin 1.5s infinite linear;
    -moz-animation: cssload-spin 1.5s infinite linear;
}

.cssload-bell {
    animation: cssload-spin 3.75s infinite linear;
    -o-animation: cssload-spin 3.75s infinite linear;
    -ms-animation: cssload-spin 3.75s infinite linear;
    -webkit-animation: cssload-spin 3.75s infinite linear;
    -moz-animation: cssload-spin 3.75s infinite linear;
}



@keyframes cssload-spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@-o-keyframes cssload-spin {
    from {
        -o-transform: rotate(0deg);
    }
    to {
        -o-transform: rotate(360deg);
    }
}

@-ms-keyframes cssload-spin {
    from {
        -ms-transform: rotate(0deg);
    }
    to {
        -ms-transform: rotate(360deg);
    }
}

@-webkit-keyframes cssload-spin {
    from {
        -webkit-transform: rotate(0deg);
    }
    to {
        -webkit-transform: rotate(360deg);
    }
}

@-moz-keyframes cssload-spin {
    from {
        -moz-transform: rotate(0deg);
    }
    to {
        -moz-transform: rotate(360deg);
    }
}
</style>