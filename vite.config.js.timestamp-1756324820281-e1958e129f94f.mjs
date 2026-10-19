// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/wagner/sindacsba/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/wagner/sindacsba/node_modules/laravel-vite-plugin/dist/index.js";
import { viteStaticCopy } from "file:///C:/laragon/www/wagner/sindacsba/node_modules/vite-plugin-static-copy/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: "resources/assets/client/css/",
          dest: "client"
        },
        {
          src: "resources/assets/client/css/bootstrap",
          dest: "client"
        },
        {
          src: "resources/assets/client/css/bootstrap-icons",
          dest: "client"
        },
        {
          src: "resources/assets/client/css/typed.js",
          dest: "client"
        },
        {
          src: "resources/assets/client/images",
          dest: "client"
        },
        {
          src: "resources/assets/client/js/",
          dest: "client"
        },
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
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFx3YWduZXJcXFxcc2luZGFjc2JhXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFx3YWduZXJcXFxcc2luZGFjc2JhXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi9sYXJhZ29uL3d3dy93YWduZXIvc2luZGFjc2JhL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG5cbiAgICAgICAgdml0ZVN0YXRpY0NvcHkoe1xuICAgICAgICAgICAgdGFyZ2V0czogW1xuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9jbGllbnQvY3NzLycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdjbGllbnQnXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogJ3Jlc291cmNlcy9hc3NldHMvY2xpZW50L2Nzcy9ib290c3RyYXAnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnY2xpZW50J1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvYXNzZXRzL2NsaWVudC9jc3MvYm9vdHN0cmFwLWljb25zJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJ2NsaWVudCdcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9jbGllbnQvY3NzL3R5cGVkLmpzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJ2NsaWVudCdcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9jbGllbnQvaW1hZ2VzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJ2NsaWVudCdcbiAgICAgICAgICAgICAgICB9LCAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNyYzogJ3Jlc291cmNlcy9hc3NldHMvY2xpZW50L2pzLycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdjbGllbnQnXG4gICAgICAgICAgICAgICAgfSwgICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvYXNzZXRzL2FkbWluL2NzcycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdhZG1pbidcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9hZG1pbi9kYXRhJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJ2FkbWluJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvYXNzZXRzL2FkbWluL2ZvbnRzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJ2FkbWluJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvYXNzZXRzL2FkbWluL2ltYWdlcycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdhZG1pbidcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2Fzc2V0cy9hZG1pbi9qcycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICdhZG1pbidcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgXVxuICAgICAgICB9KVxuICAgIF1cbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUF5UixTQUFTLG9CQUFvQjtBQUN0VCxPQUFPLGFBQWE7QUFDcEIsU0FBUyxzQkFBc0I7QUFFL0IsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFFRCxlQUFlO0FBQUEsTUFDWCxTQUFTO0FBQUEsUUFDTDtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxFQUNMO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
