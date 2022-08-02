<x-layout>
    <x-flex class="h-100" flex="justify-content-center align-items-center h-100">
        <div class="col-12 p-3">
            <div class="card text-dark p-0">
                <div class="card-header">
                    <h3 class="card-title text-center">Курсы валют</h3>
                    <x-flex flex="justify-content-center">
                        <div class="col-auto px-0">
                            <x-modal.button target="{{ $settings['target'] }}">
                                Настройки
                            </x-modal.button>
                            <x-modal id="{{ $settings['target'] }}" labelledby="{{ $settings['labelledby'] }}">

                            </x-modal>
                        </div>
                    </x-flex>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Цифр. код</th>
                                <th>Букв. код</th>
                                <th>Единиц</th>
                                <th>Валюта</th>
                                <th>Курс</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $key => $currency)
                                <tr>
                                    <td>{{ $currency->num_code }}</td>
                                    <td>{{ $currency->char_code }}</td>
                                    <td>{{ $currency->nominal }}</td>
                                    <td>{{ $currency->name }}</td>
                                    @if ($previous && $previous->get($key)->value < $currency->value)
                                        <td class="currency-up">{{ $currency->value }}</td>
                                    @elseif ($previous && $previous->get($key)->value > $currency->value)
                                        <td class="currency-down">{{ $currency->value }}</td>
                                    @else 
                                        <td>{{ $currency->value }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-flex>
</x-layout>