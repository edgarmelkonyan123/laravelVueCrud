<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="d-inline">{{ $t('texts.Sections') }}</h4>
                <a href="/section/create" class="btn btn-primary float-right" style="padding:4px 8px">{{ $t('texts.Add') }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" v-if="sections.total > 0">
                <tbody>
                    <tr v-for="(section, index) in sections.data">
                        <td>
                            <img v-bind:src="'/' + section.logo" class="img-thumbnail" width="150px">
                        </td>
                        <td>
                            <strong>{{ section.name }}</strong>
                            <p>{{ section.description }}</p>
                        </td>
                        <td class="no-wrap">
                            <strong>{{ $t('texts.Users') }}</strong>
                            <ol v-if="section.users.length > 0">
                                <li v-for="user in section.users">{{ user.name }}</li>
                            </ol>
                        </td>
                        <td class="no-wrap">
                            <a v-bind:href="'section/' + section.id + '/edit'" class="btn btn-secondary btn-sm" role="button">{{ $t('texts.Edit') }}</a>
                            <button @click="deleteSection(index)" class="btn btn-danger btn-sm">{{ $t('texts.Delete') }}</button>
                        </td>

                    </tr>
                </tbody>
                </table>
                </div>
            </div>
            <div class="card-footer">
                <pagination :data="sections" @pagination-change-page="readSections"></pagination>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data(){
            return {
                section: {
                    name: '',
                    description: '',
                    logo: '',
                    users: ''
                },
                sections: {}
            }

        },
        mounted()
        {
            this.readSections();
        },
        methods: {
            deleteSection(index)
            {
                let conf = confirm("Do you really want to delete this section?");

                if (conf === true) {
                    axios.delete('/section/' + this.sections.data[index].id)
                        .then(response => {
                            this.sections.data.splice(index, 1);
                        })
                        .catch(error => {
                            //
                        });
                }
            },
            readSections(page = 1)
            {
                axios.get('/getSections?page=' + page)
                    .then(response => {
                        this.sections = response.data;
                    });
            }
        }
    }
</script>

<style scoped>
    .no-wrap{
        white-space: nowrap;
    }
</style>