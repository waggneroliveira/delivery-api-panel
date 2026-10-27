// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/wagner/new-panel/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/wagner/new-panel/node_modules/laravel-vite-plugin/dist/index.js";
import { viteStaticCopy } from "file:///C:/laragon/www/wagner/new-panel/node_modules/vite-plugin-static-copy/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: "resources/assets/admin/css",
          dest: "admin"
        },
        {
          src: "resources/assets/admin/data",
          dest: "admin"
        },
        {
          src: "resources/assets/admin/fonts",
          dest: "admin"
        },
        {
          src: "resources/assets/admin/images",
          dest: "admin"
        },
        {
          src: "resources/assets/admin/js",
          dest: "admin"
        }
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFx3YWduZXJcXFxcbmV3LXBhbmVsXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFx3YWduZXJcXFxcbmV3LXBhbmVsXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi9sYXJhZ29uL3d3dy93YWduZXIvbmV3LXBhbmVsL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknXG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG5cbiAgICAgICAgdml0ZVN0YXRpY0NvcHkoe1xuICAgICAgICAgICAgdGFyZ2V0czogW1xuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9hZG1pbi9jc3MnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnYWRtaW4nXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogJ3Jlc291cmNlcy9hc3NldHMvYWRtaW4vZGF0YScsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdhZG1pbidcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9hZG1pbi9mb250cycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdhZG1pbidcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9hZG1pbi9pbWFnZXMnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnYWRtaW4nXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogJ3Jlc291cmNlcy9hc3NldHMvYWRtaW4vanMnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnYWRtaW4nXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF1cbiAgICAgICAgfSlcbiAgICBdLFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQXlSLFNBQVMsb0JBQW9CO0FBQ3RULE9BQU8sYUFBYTtBQUNwQixTQUFTLHNCQUFzQjtBQUUvQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFFTCxRQUFRO0FBQUEsTUFDSixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxJQUVELGVBQWU7QUFBQSxNQUNYLFNBQVM7QUFBQSxRQUNMO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLEVBQ0w7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
