@extends('layouts.app')

@push('styles')
<style type="text/css">
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .refresh{
        animation: rotate 1.5s linear infinite;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to the roulette game</div>

                <div class="card-body">
                	<div class="text-center">
                        <img src="{{ asset('images/circle.png') }}" alt="image roulette" width="250" height="250" id="circle">
                        <p id="winner" class="display-1 d-none text-primary"></p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <label for="bet" class="font-weight-bold h5">You Bet</label>
                        <select id="bet" class="custom-select col-auto">
                            <option selected >Not in</option>
                            @foreach (range(1, 12) as $number)
                                <option >{{$number}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <p class="font-weight-bold h5">Remaining Time</p>
                        <p id="timer" class="text-danger h5">Waiting to Start</p>
                        <p id="result" class="h1"></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        const circleElement = document.getElementById('circle');
        const winnerElement = document.getElementById('winner');
        const betElement = document.getElementById('bet');
        const timerElement = document.getElementById('timer');
        const resultElement = document.getElementById('result');
        Echo.channel('game')
            .listen('RemainigTimeChanged', (e) => {

                circleElement.classList.add('refresh');
                timerElement.innerText = e.time;

                winnerElement.classList.add('d-none');
                resultElement.innerText = '';
                resultElement.classList.remove('text-success');
                resultElement.classList.remove('text-danger');

            })
            .listen('WinnerNumberGenerated', (e) => {
                let winner = e.number;
                circleElement.classList.remove('refresh');
                winnerElement.classList.remove('d-none');
                winnerElement.innerText = winner;

                let bet = betElement[betElement.selectedIndex].innerText;
                console.log(bet);
                if(bet == winner){
                    resultElement.classList.add('text-success');
                    resultElement.innerText = 'YOU WINNER';
                }else{
                     resultElement.classList.add('text-danger');
                    resultElement.innerText = 'YOU LOSER';
                }
            });

    </script>
@endpush