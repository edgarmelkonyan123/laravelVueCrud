<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="d-inline" v-if="!id">{{ $t('texts.Add_User') }}</h4>
                <h4 class="d-inline" v-else>{{ $t('texts.Edit_User') }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible" v-if="error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>{{ $t('texts.Error!') }}</strong>
                </div>
                <form v-bind:action="action" method="post">
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <input v-if="id" type="hidden" name="_method" value="put" />
                    <div class="form-group">
                        <label for="name">{{ $t('texts.Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" v-bind:value="user.name">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ $t('texts.E-mail') }}</label>
                        <input type="email" class="form-control" id="email" name="email" v-bind:value="user.email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">{{ $t('texts.Password') }}</label>
                        <input type="password" class="form-control" id="pwd" name="password">
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
        action: '/user',
        csrf: window.Laravel.csrfToken,
        user: {}
      }

    },
    mounted()
    {

    },
    created() {
            if (this.id){
      this.getUser(this.id);
      this.action = this.action + '/' + this.id;
      }
    },
    methods: {
      getUser(id)
      {
        axios.get('/getUser/'+id)
            .then(response => {
              this.user = response.data;
            });
      }
    }
  }
</script>

<style scoped>

</style>