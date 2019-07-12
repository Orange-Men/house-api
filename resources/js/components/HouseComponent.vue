<template>
    <div class="container">
        <div class="py-5 text-center">
            <h2>House api</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <form v-on:submit.prevent="search" action="#">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               v-model="name"
                               placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <vue-slider v-model="price"
                                    :max="1000000"
                                    :tooltip="'focus'"
                                    :use-keyboard="true"></vue-slider>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="bedrooms">Bedrooms</label>
                            <input type="number"
                                   class="form-control"
                                   id="bedrooms"
                                   v-model="bedrooms"
                                   placeholder="Bedrooms">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bathrooms">Bathrooms</label>
                            <input type="number"
                                   class="form-control"
                                   id="bathrooms"
                                   v-model="bathrooms"
                                   placeholder="Bathrooms">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="storeys">Storeys</label>
                            <input type="number"
                                   class="form-control"
                                   id="storeys"
                                   v-model="storeys"
                                   placeholder="Storeys">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="garages">Garages</label>
                            <input type="number"
                                   class="form-control"
                                   id="garages"
                                   v-model="garages"
                                   placeholder="Garages">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div class="text-center" v-show="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-3 col-6" v-for="house in houses">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ house.name }}</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Price: {{ house.price }}</li>
                            <li class="list-group-item">Bedrooms: {{ house.bedrooms }}</li>
                            <li class="list-group-item">Bathrooms: {{ house.bathrooms }}</li>
                            <li class="list-group-item">Storeys: {{ house.storeys }}</li>
                            <li class="list-group-item">Garages: {{ house.garages }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "HouseComponent",
        data: function () {
            return {
                name: '',
                price: [0, 1000000],
                bedrooms: '',
                bathrooms: '',
                storeys: '',
                garages: '',
                houses: [],
                loading: false
            }
        },
        methods: {
            search: function () {
                let self = this
                self.loading = true
                let options = {
                    params: {
                        name: self.name,
                        price: self.price,
                        bedrooms: self.bedrooms,
                        bathrooms: self.bathrooms,
                        storeys: self.storeys,
                        garages: self.garages
                    }
                }
                removeEmpty(options.params)
                axios.get('/api/house', options)
                    .then(function (res) {
                        if (res.data.status === 'success') {
                            self.houses = res.data.data.houses
                            if (self.houses.length === 0)
                                self.$notify({
                                    type: 'warn',
                                    title: 'No results were found.'
                                });
                        }
                    })
                    .catch(function (err) {
                        if (err.response.data.status === 'error')
                            self.$notify({
                                type: 'warn',
                                title: err.response.data.message
                            });
                    }).finally(function () {
                    self.loading = false
                });
            }
        }
    }

    function removeEmpty(obj) {
        Object.keys(obj).forEach(function(key) {
            if (obj[key] === '') delete obj[key]
        });
    }
</script>

<style scoped>

</style>