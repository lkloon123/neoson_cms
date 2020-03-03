<template functional>
  <div class="card card-statistic-1 mb-0">
    <div class="card-icon bg-primary">
      <slot name="icon" />
    </div>
    <div class="card-wrap">
      <div class="card-header">
        <h4>{{ props.header }}</h4>
      </div>
      <div class="card-body">
        {{ props.body }}
        <slot name="body" />
        <slot />
      </div>
    </div>
  </div>
</template>
