import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig( {
	publicDir: false,

	css: {
		preprocessorOptions: {
			// Lets SCSS load Chassis's tools from vendor/:
			// @use 'techkodeninja/chassis/scss/02.tools' as ui;
			scss: { loadPaths: [ path.resolve( __dirname, 'vendor' ) ] },
		},
	},

	build: {
		outDir: 'public/assets',   // Vite only manages this folder
		assetsDir: '',             // no extra nesting
		manifest: 'manifest.json', // lives at public/assets/manifest.json
		emptyOutDir: true,         // cleans old CSS/JS on each build
		rollupOptions: {
			input: {
				app: path.resolve( __dirname, 'resources/js/app.js' ),
				screen: path.resolve( __dirname, 'resources/scss/screen.scss' ),
				'customize-controls': path.resolve( __dirname, 'resources/js/customize-controls.js' ),
				// The stylesheet gets a -style suffix so its output name doesn't collide with
				// the script of the same name.
				'customize-controls-style': path.resolve( __dirname, 'resources/scss/customize-controls.scss' ),
				'customize-preview': path.resolve( __dirname, 'resources/js/customize-preview.js' ),
			},
			output: {
				entryFileNames: 'js/[name]-[hash].js',
				chunkFileNames: 'js/[name]-[hash].js',
				assetFileNames: ( { name } ) =>
					name && name.endsWith( '.css' )
						? 'css/[name]-[hash][extname]'
						: 'media/[name]-[hash][extname]',
			},
		},
	},
} );
