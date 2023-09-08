<script setup>
    import {
        computed    
    } from 'vue'

    const props = defineProps({      
        total_data: {
            type: Number,
        },
        limit: {
            type: Number
        },
        current_page: {
            type: Number
        },
        loading: {
            type: Boolean
        }
    })

    const emit = defineEmits(['change-page','update:current_page'])    

    const total_pages = computed(() => {
        return Math.ceil(props.total_data / props.limit);
    });

    const startPage = computed(() => {
        if (props.current_page == 1) {
            return 1;
        }

        if (props.current_page == total_pages.value) {
            return Number(total_pages.value) - (5 - 1);
        }

        // When inbetween
        return props.current_page - 1;
    });

    const pages = computed(() => {
        const range = [];

        for (let x = Number(startPage.value); x <= Math.min(Number(startPage.value) + 5
                 - 1, Number(total_pages.value)); x++) {
            if (x > 0) {
                range.push({
                    name: x,
                    isDisabled: x === props.current_page
                });
            }

        }

        return range;
    })

    const isInFirstPage = computed(() => {
        return props.current_page === 1;
    })

    const isInLastPage = computed(() => {
        return props.current_page == total_pages.value;
    });      

    function changePage(page) {
        emit('update:current_page', page)
        emit('change-page')
    }

    function onClickFirstPage() {
        changePage(1);

    }

    function onClickPreviousPage() {
        changePage(props.current_page - 1);

    }

    function onClickPage(page) {
        changePage(page);
    }

    function onClickNextPage() {
        changePage(props.current_page + 1);
    }

    function onClickLastPage() {
        changePage(total_pages.value);
    }

</script>


<template>
    <div>
        <ul class="custom-vue-pagination">
            <li>
                <button type="button" class="btn-prev-next-pagination" @click="onClickFirstPage"
                    :disabled="isInFirstPage || props.loading || props.total_data == 0">
                    <i class="fa fa-arrow-left"></i>
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-pagination" @click="onClickPreviousPage"
                    :disabled="isInFirstPage || props.loading">
                    <i class="fa fa-chevron-left"></i>
                </button>
            </li>

            <li v-for="page in pages" :key="page.name">
                <button type="button" :class="props.current_page == page.name ? 'active' : ''"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled || props.loading || props.total_data == 0">
                    {{ page.name }}
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-pagination" @click="onClickNextPage"
                    :disabled="isInLastPage || props.loading || props.total_data == 0">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-pagination" @click="onClickLastPage"
                    :disabled="isInLastPage || props.loading || props.total_data == 0">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </li>
        </ul>
    </div>
</template>


<style scoped>   
    .custom-vue-pagination {
        display: flex;
        flex-wrap: wrap;
        list-style-type: none;
        margin-bottom: 15px;
    }

    .custom-vue-pagination button {
        padding: 5px;
        font-size: 12px;
        background-color: #fff !important;
        border: 0 !important;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 5px;
        height: 35px;
    }

    .custom-vue-pagination button.btn-prev-next-pagination {
        background: #F7F9FB !important;
        border-radius: 8px !important;
    }

    .custom-vue-pagination button.active {
        background: #009EF7  !important;
        border-radius: 8px;
        color: #fff !important;
    }

    .custom-vue-pagination {
        width: 100%;
    }
</style>
