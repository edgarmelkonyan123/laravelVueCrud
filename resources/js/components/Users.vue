<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="d-inline">{{ $t('texts.Users') }}</h4>
                <a href="/user/create" class="btn btn-primary float-right" style="padding:8px">{{ $t('texts.Add') }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" v-if="users.total > 0">
                    <tbody>
                    <tr v-for="(user, index) in users.data">
                        <td>
                            {{ user.name }}
                        </td>
                        <td>
                            {{ user.email }}
                        </td>
                        <td>
                            {{ user.created_at }}
                        </td>
                                            <td>
                        <a v-bind:href="'user/' + user.id + '/edit'" class="btn btn-secondary btn-sm" role="button">{{ $t('texts.Edit') }}</a>
                        <button @click="deleteUser(index)" class="btn btn-danger btn-sm">{{ $t('texts.Delete') }}</button>
                                            </td>

                                        </tr>
                    </tbody>
                     </table>
                </div>
            </div>
            <div class="card-footer">
                <pagination :data="users" @pagination-change-page="readUsers"></pagination>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data(){
            return {
                user: {
                    name: '',
                    email: '',
                    created_at: ''
                },
                users: {}
            }

        },
        mounted()
        {
            this.readUsers();
        },
        methods: {
            deleteUser(index)
            {
                let conf = confirm(this.$t('texts.Delete_Question'));

                if (conf === true) {
                    axios.delete('/user/' + this.users.data[index].id)
                        .then(response => {
                            this.users.data.splice(index, 1);
                        })
                        .catch(error => {
                            //
                        });
                }
            },
            readUsers(page = 1)
            {
                axios.get('/getUsers?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            }
        }
    }
</script>