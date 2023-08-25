<style>
    {
        box-sizing: border-box;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        padding: 2% 0% 2% 1%;
        border-radius: 25px;
        background-color: rgba(0, 0, 0, 0.27) !important;

    }
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,10);
        background-color: lightskyblue;
    }
    .column_left {
        float: left;
        width: 11%;
        height: 10%;
        padding-left: 1rem;
    }
    .column_right {
        float: left;
        width: 89%;
        padding-left: 1rem;

    }
    .row_new:after {
        content: "";
        display: table;
        clear: both;
    }

</style>
<div>




    <form action="{{ route('dashboard') }}">

        <div class="py-2">
            <x-input style="height: 3.5rem" icon="light-bulb" right-icon="search"  type="search" class="form-control" name="search_value" placeholder="&nbsp;  Search data...."> </x-input>
        </div>

    </form>

    <form action="{{ route('generate_report') }}">

        <div style="margin-bottom: -1rem">
            <x-button style="width: 15%" dark label="GENERATE REPORT" type="submit" />
        </div>

    </form>

    <div class="py-2">
        <hr>
    </div>

    <?php if($count_data == "0" || $count_data == "1") { ?>
    <p style="margin-bottom: .3rem; font-size: .75rem">About {{ $count_data }} result ({{ $execution_time }} seconds) </p>
    <?php } else { ?>
    <p style="margin-bottom: .3rem; font-size: .75rem">About {{ $count_data }} results ({{ $execution_time }} seconds) </p>
    <?php } ?>

    <div>

        @foreach( $value as $data )

            <div style="margin-top: 1rem">

            </div>

            <?php if( $data['reservationist'] == Auth::user()->name){ ?>
                <x-button.circle onclick="deleteData('{{ $data['id'] }}')" xs negative icon="x"  />
            <?php } ?>

            <div class="card">
                <div class='row_new'>
                    <div class='column_left'>
                        <img src='{{ asset('/img/search_img.png') }}' style='height: 110px;'>
                    </div>
                    <div class='column_right'>
                        <p style="font-size: 1.8rem; text-transform: capitalize;"><b> {{ strtoupper($data['id']) }} </b></p>
                        <p style="font-size: .8rem; text-transform: uppercase; margin-bottom: 1rem">reservation number</p>

                        <p style="margin-top: .3rem"><i>Room Name:</i> {{ $data['room_name'] }}</p>
                        <p style="margin-top: .3rem"><i>Reserved Start Time: {{ date_format(date_create($data['start_time']),"H:i")  }}</i> </p>
                        <p style="margin-top: .3rem"><i>Reserved Until: {{ date_format(date_create($data['end_time']),"H:i")  }}</i> </p>
                        <p style="margin-top: .3rem"><i>Reserved Date: {{ date_format(date_create($data['created_at']),"M d, Y")  }}</i> </p>

                        <br>
                        <p style="margin-top: .3rem"><i>Reserved By:</i> {{ substr($data['reservationist'],0,100)  }}</p>

                    </div>
                </div >
            </div>

        @endforeach

    </div>
    <div style="margin-top: 1%">
        {{ $value->withQueryString()->links() }}
    </div>
    <br>

</div>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteData(id){

        if(id === ""){
            Swal.fire(
                'RESERVATION ID IS EMPTY',
                'Please check the search data ID.',
                'error'
            )
        } else {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel please.',
            }).then((result) => {
                if (result.isConfirmed) {

                    swal.fire({
                        title: 'Please Wait..!',
                        text: 'Is working..',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.fire.showLoading()
                        }
                    })

                    $.ajax({
                        url:'./delete_reservation/'+ id,
                        type:'POST',
                        data:{"id":id},
                        success:function(data){

                            Swal.fire({
                                title: 'You have successfully deleted the reservation.',
                                allowOutsideClick: false,
                                showCancelButton: false,
                                confirmButtonText: 'Okay',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })

                        }
                    });

                } else {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })

        }

    }

</script>
