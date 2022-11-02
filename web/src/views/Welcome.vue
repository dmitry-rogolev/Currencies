<template>
    <FlexComponent :classes="[ 'justify-content-center', 'align-items-center', 'min-vh-100', 'bg-secondary', 'p-3' ]">
        <div v-if="currencies" :class="[ 'card', 'text-dark', 'p-0' ]">
            <div class="card-header">
                <h3 :class="[ 'card-title', 'text-center' ]">{{ header }}</h3>
                <FlexComponent classes="justify-content-center">
                    <ModalComponent ref="ModalSettings" @save="settings" buttonClasses="btn-dark" title="Настройки" header="Настройки">
                        <template v-slot:button>
                            Настройки
                        </template>
                        <template v-slot:window>
                            <form>
                                <div class="mb-2">
                                    <SelectComponent v-model="dataLoads" name="loads[]" label="Загружаемые валюты" multiple>
                                        <option v-for="original in originals" :key="original.num_code" :value="original.num_code">
                                            {{ original.char_code }} | {{ original.name }}
                                        </option>
                                    </SelectComponent>
                                </div>
                                <div class="mb-2">
                                    <SelectComponent v-model="dataVisibles" name="visible[]" label="Отображаемые валюты" multiple>
                                        <option v-for="visible in visibles" :key="visible.num_code" :value="visible.num_code">
                                            {{ visible.char_code }} | {{ visible.name }}
                                        </option>
                                    </SelectComponent>
                                </div>
                                <div class="mb-2">
                                    <InputComponent v-model="dataInterval" name="interval" type="number" label="Интервал обновления данных в секундах" />
                                </div>
                            </form>
                        </template>
                    </ModalComponent>
                </FlexComponent>
                <p :class="[ 'my-2', 'text-center' ]">Интервал обновления данных в секундах: {{ interval }}</p>
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
                        <tr v-for="currency in currencies" :key="currency.num_code">
                            <td>{{ currency.num_code }}</td>
                            <td>{{ currency.char_code }}</td>
                            <td>{{ currency.nominal }}</td>
                            <td>{{ currency.name }}</td>
                            <td :class="[ currency.changes === 1 ? 'currency-up' : '', currency.changes === -1 ? 'currency-down' : '' ]">{{ currency.value }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <SpinnerComponent classes="text-light" v-else />
    </FlexComponent>
</template>

<script>
    import $ from "jquery";

    export default {
        name: "Welcome", 

        computed: {
            header()
            {
                return this.$store.state.header;
            }, 

            currencies()
            {
                return this.$store.state.currencies;
            }, 

            originals()
            {
                return this.$store.state.originals;
            }, 

            visibles()
            {
                return this.$store.state.visibles;
            }, 

            interval()
            {
                return this.$store.state.interval;
            }, 

            token()
            {
                return this.$store.state.token;
            }, 
        }, 

        data()
        {
            return {
                dataLoads: [], 
                dataVisibles: [], 
                dataInterval: null, 
            };
        }, 

        methods: {
            async settings()
            {
                this.$refs.ModalSettings.close();

                let data = await $.ajax({
                    url: "/settings", 
                    method: "POST", 
                    data: {
                        _token: this.token, 
                        loads: JSON.stringify(this.dataLoads), 
                        visibles: JSON.stringify(this.dataVisibles), 
                        interval: this.dataInterval, 
                    }, 
                    headers: {
                        "X-CSRF-TOKEN": this.token, 
                    }, 
                });

                this.$store.commit("currencies", data.currencies);
                this.$store.commit("visibles", data.visibles);
                this.$store.commit("interval", data.interval);
            }, 
        }, 

        beforeMount()
        {
            this.$store.dispatch("currencies");
        }, 
    }
</script>

<style>

</style>
