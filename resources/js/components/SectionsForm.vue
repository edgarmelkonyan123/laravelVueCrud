<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="d-inline" v-if="!id">{{ $t('texts.Add_Section') }}</h4>
                <h4 class="d-inline" v-else>{{ $t('texts.Edit_Section') }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible" v-if="error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $t('texts.Error!') }}</strong>
                </div>
                <form v-bind:action="action" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <input v-if="id" type="hidden" name="_method" value="put" />
                    <div class="form-group">
                        <label for="name">{{ $t('texts.Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" v-bind:value="section.name">
                    </div>
                    <div class="form-group">
                        <label for="description">{{ $t('texts.Description') }}</label>
                        <textarea class="form-control" id="description" name="description">{{section.description}}</textarea>
                    </div>
                    <p>{{ $t('texts.Logo') }}</p>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="logo" name="logo">
                        <label class="custom-file-label" for="logo">{{ $t('texts.Select_File') }}</label>
                    </div>
                    <h2>{{ $t('texts.Users') }}</h2>
                    <div class="custom-control custom-checkbox mb-3" v-for="(user, index) in users">
                        <input :checked="isUserRelated(user.id)" type="checkbox" class="custom-control-input" v-bind:id="'users_' + index" name="users[]" v-bind:value="index+1"><label class="custom-control-label" v-bind:for="'users_' + index">{{user.name}} ({{user.email}})</label>
                    </div>
                    <button type="submit" class="btn btn-primary" v-if="id">{{ $t('texts.Update') }}</button>
                    <button type="submit" class="btn btn-primary" v-else>{{ $t('texts.Save') }}</button>
                </form>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</template>

<script>

  export default {
    props: {
      id: { type: String, required: false },
      error: { type: String, required: false }
    },
    data(){
      return {
        action: '/section',
        csrf: window.Laravel.csrfToken,
        users: {},
        section: []
      }

    },
    mounted()
    {
      this.readUsers();
    },
    created() {
      if (this.id){
        this.getSection(this.id);
        this.action = this.action + '/' + this.id;
      }
    },
    methods: {
      getSection(id)
      {
        axios.get('/getSection/'+id)
            .then(response => {
              this.section = response.data;
            });
      },
      readUsers()
      {
        axios.get('/getAllUsers')
            .then(response => {
              this.users = response.data;
            });
      },
      isUserRelated(id)
      {
        if(this.section.users){
          for(var i=0; i < this.section.users.length; i++){
            if(this.section.users[i].id == id){
              return true
            }
          }
        }
        return false
      }
    }
  }
</script>

<style scoped>

</style>