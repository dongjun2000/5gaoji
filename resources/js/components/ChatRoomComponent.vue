<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-transparent">
                    <strong>聊天室</strong>
                </div>
                <div class="card-body">
                    <ul id="chat-window" class="list-unstyled" style="height: 300px; overflow: auto">

                        <li class="media mb-2" v-for="(history, index) in histories">
                            <div class="media-left">
                                <a :href="'/users/' + history.name" target="_blank">
                                    <img :src="history.avatar"
                                         class="img-thumbnail mr-3" style="width: 52px; height: 52px;">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="media-heading mt-0 mb-1">
                                    <div>
                                        <a :href="'/users/' + history.name" target="_blank" class="text-dark">{{
                                            history.name}}</a>
                                        对
                                        <a v-if="history.is_private" :href="'/users/' + history.to_name" target="_blank"
                                           class="text-dark">{{ history.to_name }}</a>
                                        <span v-else>{{ history.to_name}}</span>
                                        说：
                                    </div>
                                    <span class="float-right text-muted">{{ history.time}}</span>
                                </div>
                                <div class="media-body text-secondary">
                                    {{ history.content }}
                                </div>
                                <div class="text-center text-muted" v-if="index === (histories.length - 1)">
                                    ---------- 以上为历史聊天记录 ----------
                                </div>
                            </div>

                        </li>

                        <li class="media mt-3" v-for="message in messages">
                            <div class="media-left">
                                <a :href="'/users/' + message.name" target="_blank">
                                    <img :src="message.avatar"
                                         class="img-thumbnail mr-3" style="width: 52px; height: 52px;">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="media-heading mt-0 mb-1">
                                    <div>
                                        <a :href="'/users/' + message.name" target="_blank" class="text-dark">{{
                                            message.name}}</a>
                                        对
                                        <a v-if="message.is_private" :href="message.to_name" target="_blank"
                                           class="text-dark">{{ message.to_name }}</a>
                                        <span v-else>{{ message.to_name }}</span>
                                        说：
                                    </div>
                                    <span class="float-right text-muted">{{ message.time}}</span>
                                </div>
                                <div class="media-body text-secondary">
                                    {{ message.content }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <form @submit.prevent="sendMessage">
                <div class="mt-3">
                    <div class="mb-2">
                        <strong class="mb-2">私聊</strong>
                    </div>
                    <select v-model="to_user_id" class="form-control">
                        <option value="" selected>所有人</option>
                        <option :value="user.id" v-for="user of users">{{ user.name }}</option>
                    </select>
                </div>

                <div class="mt-3">
                    <div class="mb-2">
                        <strong class="mb-2">内容</strong>
                    </div>
                    <div class="form-group">
                        <input type="text" v-model="content" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-sm btn-success float-right">发送</button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <strong>在线用户
                        <small>({{ onlineUsersCount }})</small>
                    </strong>
                </div>
                <div class="card-body p-2" style="height: 530px; overflow: auto">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2" v-for="user in users">
                            <a href="">
                                <img :src="user.avatar" :alt="user.name" :title="user.name"
                                     class="img-thumbnail mr-3" style="width: 52px; height: 52px;">
                            </a>
                            <a :href="'/users/' + user.name" target="_blank" class="text-dark">{{ user.name}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let ws = new WebSocket('ws://localhost:2346');

    export default {
        data() {
            return {
                to_user_id: '',
                content: '',
                onlineUsersCount: 0,
                users: [],
                messages: [],
                histories: [],
            }
        },
        created() {         // 在实例创建完成后被立即调用
            ws.onmessage = (e) => {
                let data = JSON.parse(e.data);

                // 如果没有类型，就为空
                let type = data.type || '';

                switch (type) {
                    case 'ping':
                        ws.send('pong');
                        break;
                    case 'init':
                        axios.post('/chat/init', {client_id: data.client_id});
                        break;
                    case 'logout':
                        --this.onlineUsersCount;
                        this.$delete(this.users, data.client_id);
                        break;
                    case 'say':
                        this.messages.push(data.data);
                        break;
                    case 'history':
                        this.histories = data.data;
                        break;
                    case 'users':
                        let users = data.data;
                        this.users = users;
                        this.onlineUsersCount = data.count;
                    default:
                        console.log(data);
                }
            }
        },
        methods: {
            sendMessage() {
                axios.post('/chat/say', {to_user_id: this.to_user_id, content: this.content});
                this.user = '';
                this.content = '';
            },
        },
        updated() {     // 由于数据更改导致的虚拟 DOM 重新渲染和打补丁，在这之后会调用该钩子。
            let ele = document.getElementById('chat-window');
            ele.scrollTop = ele.scrollHeight;
        },
        mounted() {
            console.log('chat-room.')
        }
    }
</script>

<style>

</style>

