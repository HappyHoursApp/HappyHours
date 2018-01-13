<div class="container">
    <div class="alert-danger text-center">
        <h3><strong>Uh oh, there were some issues!</strong></h3>
        <repeat group="{{ @errors }}" value="{{ @error }}">
            <h4 class="">{{ @error }}</h4>
        </repeat>
    </div>
</div>