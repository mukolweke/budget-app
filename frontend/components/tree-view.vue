<script setup>

defineProps({
  nodes: Array,
});

const toggleNode = (node) => {
  node.open = !node.open;
}

</script>

<template>
  <ul class="space-y-2">
    <li v-for="node in nodes" :key="node.id">
      <div class="flex items-center space-x-2 mb-2">
        <span
          class="w-3 h-3 rounded-full bg-green-500"
          v-if="node.children"
          @click="toggleNode(node)"
        ></span>
        <span>{{ node.title }}</span>
      </div>

      <TreeView v-if="node.children" :nodes="node.children" class="ml-5" />
    </li>
  </ul>
</template>


