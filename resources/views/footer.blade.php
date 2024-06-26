	<footer class="py-2 px-4 bg-white footer text-center">
		{{ date('Y') }} &copy; Created with <svg class="footer-heart icon icon-heart"><use xlink:href="#icon-heart"></use></svg> by {{ env('APP_OWNER') }}
	</footer>

	@include('svg')

	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha256-m81NDyncZVbr7v9E6qCWXwx/cwjuWDlHCMzi9pjMobA=" crossorigin="anonymous"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js" integrity="sha256-Y16qmk55km4bhE/z6etpTsUnfIHqh95qR4al28kAPEU=" crossorigin="anonymous"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js" integrity="sha256-P+JgcxEeZtxwYS1+TAAuusKFM646SB8Oodk0TYu9zuo=" crossorigin="anonymous"></script>
	<script defer src="{{ asset('js/functions.js?v=1.0.0') }}"></script>
	<script defer src="{{ asset('js/scripts.js?v=1.0.0') }}"></script>
</body>
</html>