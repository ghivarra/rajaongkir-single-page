	<footer class="py-2 px-4 bg-white footer text-center">
		{{ date('Y') }} &copy; Created with <svg class="footer-heart icon icon-heart"><use xlink:href="#icon-heart"></use></svg> by {{ env('APP_OWNER') }}
	</footer>

	@include('svg')

	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js" integrity="sha256-m81NDyncZVbr7v9E6qCWXwx/cwjuWDlHCMzi9pjMobA=" crossorigin="anonymous"></script>
	<script defer src="{{ asset('js/scripts.js?v='.time()) }}"></script>
</body>
</html>