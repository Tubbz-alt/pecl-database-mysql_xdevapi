# TODO: We're writing into srcdir, not builddir!

$(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx.proto
	$(PROTOC) --cpp_out $(srcdir)/xmysqlnd/proto_gen/ --proto_path $(srcdir)/xmysqlnd/proto_def/ $(srcdir)/xmysqlnd/proto_def/mysql*.proto

$(srcdir)/xmysqlnd/proto_gen/mysqlx_connection.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_connection.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_crud.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_crud.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_datatypes.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_datatypes.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_expect.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_expect.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_expr.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_expr.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_notice.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_notice.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_resultset.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_resultset.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_session.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_session.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/proto_gen/mysqlx_sql.pb.cc: $(srcdir)/xmysqlnd/proto_def/mysqlx_sql.proto $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/%.cc: $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/messages/%.cc: $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/xmysqlnd/%.cc: $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

$(srcdir)/xmysqlnd/xmysqlnd/crud_parsers/%.cc: $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc

BUILT_SOURCES = $(srcdir)/xmysqlnd/proto_gen/mysqlx_connection.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_datatypes.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_expr.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_session.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_crud.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_expect.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_notice.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_resultset.pb.cc \
	 $(srcdir)/xmysqlnd/proto_gen/mysqlx_sql.pb.cc

protofiles: $(srcdir)/xmysqlnd/proto_gen/mysqlx_connection.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_datatypes.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_expr.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_session.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_crud.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_expect.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_notice.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_resultset.pb.cc $(srcdir)/xmysqlnd/proto_gen/mysqlx_sql.pb.cc
