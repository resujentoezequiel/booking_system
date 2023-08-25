<style>
    .alert{
        width:100%;
        margin:20px auto;
        padding:30px;
        position:relative;
        border-radius:5px;
        box-shadow:0 0 15px 5px #ccc;
        background-color: #a8f0c6
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div style="width: 92%; margin: auto;">
            <div class="" style="width: 100%">
                <div class="">

                    @if ($message = Session::get('success_add'))
                        <div class="alert" style="margin-bottom: 3rem">
                            <button style=" float: right !important;" type="button" class="close_alert" onclick="hideAlert()">×</button>
                            <h3>Good job!</h3>
                            <strong>{{ $message }}</strong>
                        </div>

                    @endif

                    <div>
                        <livewire:reservationist.create-reserve/>
                    </div>

                    <div class="py-2">
                        <hr>
                    </div>

                    <div style="margin-top: 1%">
                        <livewire:reservationist.reservation-dashboard/>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

    function hideAlert(){
        hide(document.querySelectorAll('.alert'));
    }

    function hide (elements) {
        elements = elements.length ? elements : [elements];
        for (var index = 0; index < elements.length; index++) {
            elements[index].style.display = 'none';
        }
    }

</script>
