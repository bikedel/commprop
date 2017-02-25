<template>
    <div class="dropdown">
        <multiselect
            :selected.sync="selected"
            @update="updateSelected"
            :show-labels="true"
            :options="options"
            :searchable="true"
            :allow-empty="true"
            :multiple="true"
            key="name"
            label="name"
        ></multiselect>
    </div>
</template>

<script>
    import { Multiselect } from 'vue-multiselect';

    export default {


        components: { Multiselect },

  data () {
    return {
      selected: []


    }
  },
        props: {
            options: {},
            placeholder: {
                default: 'Select one' 
            },
            showLabel: {
                type: Boolean,
                default: true
            }

        },

  methods: {
    updateSelected (newSelected) {
      this.selected = newSelected
    }
  }
    
     
    
  
};

</script>