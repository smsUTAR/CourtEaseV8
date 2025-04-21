@props(['image'])

<style>
    .bg-fullscreen {
        background-image: url('{{ $image }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;  /* Use min-height instead of height */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .card-wrapper {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 2rem; 
        border-radius: 20px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 600px;
    }
</style>

<div class="bg-fullscreen">
    <div class="card-wrapper">
        {{ $slot }}
    </div>
</div>
