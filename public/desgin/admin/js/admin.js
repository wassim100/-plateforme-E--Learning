(async function(){
  const $ = (s)=>document.querySelector(s);
  const esc=(s)=>String(s).replace(/[&<>"']/g,(m)=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;' }[m]));
  try{
    // Optional: switch to PHP API instead of Node API by setting API_BASE
    // const API_BASE = 'http://localhost:8080';
    // fetch(`${API_BASE}/admin/stats`).then(r=>r.json()).then(console.log);

    const stats = await (await fetch('/api/admin/stats')).json();
    $('#kpi-users').textContent = stats.users.total;
    $('#kpi-courses').textContent = stats.courses.total;
    $('#kpi-categories').textContent = stats.categories.total;
    $('#kpi-enrollments').textContent = stats.enrollments.total;
    $('#kpi-quizzes').textContent = stats.quizzes.total;
    $('#kpi-questions').textContent = stats.questions.total;

    const users = await (await fetch('/api/recent/users')).json();
    const tbody = $('#users-tbody');
    tbody.innerHTML = users.map(u=>`<tr><td>${u.id}</td><td>${esc(u.name)}</td><td>${esc(u.email)}</td><td>${esc(u.role||'student')}</td></tr>`).join('');

    if(window.Chart){
      new Chart($('#rolesChart'),{ type:'doughnut', data:{ labels:['Students','Tutors','Admins'], datasets:[{ data:[stats.users.students, stats.users.tutors, stats.users.admins], backgroundColor:['#6c5ce7','#0984e3','#00b894'] }] }, options:{ plugins:{ legend:{ position:'bottom' } } } });
      const weekly = await (await fetch('/api/analytics/registrations')).json();
      new Chart($('#weeklyChart'),{ type:'line', data:{ labels: weekly.labels, datasets:[{ label:'Registrations', data: weekly.data, fill:false, borderColor:'#6c5ce7', tension:.25 }] }, options:{ scales:{ y:{ beginAtZero:true } } } });
    }
  }catch(e){ console.error('Admin init failed', e); }
})();
