

document.addEventListener('DOMContentLoaded', function () {
  const capsWarning = document.getElementById('capsLockWarning');
  const capsSpacing = document.getElementById('capsLockSpacing');

  function checkCapsLock(event) {
    if (event.getModifierState && event.getModifierState('CapsLock')) {
      capsWarning.style.display = 'block';
      capsSpacing.style.display = 'none';
    } else {
      capsWarning.style.display = 'none';
      capsSpacing.style.display = 'block';
    }
  }

  document.addEventListener('keydown', checkCapsLock);
  document.addEventListener('keyup', checkCapsLock);
});



/**
<script>
  const capsWarning = document.getElementById('capsLockWarning');

  document.addEventListener('keydown', function (event) {
    if (event.getModifierState && event.getModifierState('CapsLock')) {
      capsWarning.style.display = 'block';
    } else {
      capsWarning.style.display = 'none';
    }
  });

  document.addEventListener('keyup', function (event) {
    if (!event.getModifierState || !event.getModifierState('CapsLock')) {
      capsWarning.style.display = 'none';
    }
  });
</script>
*/
