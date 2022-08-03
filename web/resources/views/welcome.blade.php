<x-layout>
    <x-flex class="h-100" flex="justify-content-center align-items-center h-100">
        <div class="col-12 p-3">
            <div class="card text-dark p-0">
                <div class="card-header">
                    <h3 class="card-title text-center">Курсы валют</h3>
                    <x-flex flex="justify-content-center">
                        <div class="col-auto px-0">
                            <x-modal.button class="btn-dark" target="{{ $settings['target'] }}">
                                Настройки
                            </x-modal.button>
                            <x-modal id="{{ $settings['target'] }}" labelledby="{{ $settings['labelledby'] }}">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="{{ $settings['labelledby'] }}">Настройки</h3>
                                    <x-modal.close />
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('settings') }}" method="POST">
                                        @csrf 
                                        <div class="form-group">
                                            <x-form.select name="loads[]" label="Загружаемые валюты" multiple>
                                                @foreach ($originals as $original)
                                                    <option value="{{ $original->num_code }}">
                                                        {{ $original->char_code }} | {{ $original->name }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                        </div>
                                        <div class="form-group">
                                            <x-form.select name="visible[]" label="Отображаемые валюты" multiple>
                                                @foreach ($originals as $original)
                                                    <option value="{{ $original->num_code }}">
                                                        {{ $original->char_code }} | {{ $original->name }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                        </div>
                                        <div class="form-group">
                                            <x-form.input name="interval" type="number" label="Интервал обновления данных в секундах" value="{{ old('interval') }}" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <x-button.close data-dismiss="modal" />
                                    <x-button.save type="submit" onclick="this.closest('.modal').getElementsByTagName('form').item(0).submit();" />
                                </div>
                            </x-modal>
                        </div>
                    </x-flex>
                    <x-form.error class="my-2" />
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
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->num_code }}</td>
                                    <td>{{ $currency->char_code }}</td>
                                    <td>{{ $currency->nominal }}</td>
                                    <td>{{ $currency->name }}</td>
                                    @if ($previous->isNotEmpty() && $previous->has($currency->num_code) && $previous->get($currency->num_code) < $currency->value)
                                        <td class="currency-up">{{ $currency->value }}</td>
                                    @elseif ($previous->isNotEmpty() && $previous->has($currency->num_code) && $previous->get($currency->num_code) > $currency->value)
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